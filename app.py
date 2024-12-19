import numpy as np
import pandas as pd
import yfinance as yf
from keras.models import load_model
import streamlit as st
import matplotlib.pyplot as plt
from sklearn.preprocessing import MinMaxScaler


# Streamlit header
st.header('Stock Market Predictor')

# Input for stock symbol
stock = st.text_input('Enter Stock Symbol', 'GOOG')

start = '2012-01-01'
end = '2030-12-31'


# Caching function to load stock data
@st.cache_data
def load_stock_data(stock, start, end):
    """Load stock data using Yahoo Finance."""
    return yf.download(stock, start, end)


data = load_stock_data(stock, start, end)

col1, col2 = st.columns([6, 4])

with col1:
    st.subheader('Stock Data')
    st.write(data)

with col2:
    st.subheader(f"{stock} Closing Price Chart")
    st.line_chart(data['Close'])


# Data preparation for training/testing and scaling
@st.cache_data
def prepare_data(data):
    """Prepare data for training and testing with scaling."""
    # Split data into training and test sets
    data_train = pd.DataFrame(data.Close[0: int(len(data) * 0.80)])
    data_test = pd.DataFrame(data.Close[int(len(data) * 0.80): len(data)])

    # Initialize scaler and fit on training data
    scaler = MinMaxScaler(feature_range=(0, 1))
    data_train_scaled = scaler.fit_transform(data_train.values.reshape(-1, 1))
    
    # Take the last 100 days for better test preparation
    pas_100_days = data_train.tail(100)
    data_test = pd.concat([pas_100_days, data_test], ignore_index=True)
    data_test_scaled = scaler.transform(data_test.values.reshape(-1, 1))

    return scaler, data_train_scaled, data_test_scaled


scaler, data_train_scaled, data_test_scaled = prepare_data(data)


# Load pre-trained model
@st.cache_data
def load_trained_model():
    """Load the pre-trained stock prediction model."""
    return load_model(r"C:\xampp\htdocs\Stock\admin\my-app\Stock Predictions Model.keras")


model = load_trained_model()


# Visualize Moving Averages (50, 100, 200 days)
st.subheader('Stock Price with MA50')
ma_50_days = data['Close'].rolling(50).mean()
fig1 = plt.figure(figsize=(8, 6))
plt.plot(data['Close'], 'g', label='Stock Price')
plt.plot(ma_50_days, 'r', label='MA50')
plt.legend()
st.pyplot(fig1)

st.subheader('Stock Price with MA50 vs MA100')
ma_100_days = data['Close'].rolling(100).mean()
fig2 = plt.figure(figsize=(8, 6))
plt.plot(data['Close'], 'g', label='Stock Price')
plt.plot(ma_50_days, 'r', label='MA50')
plt.plot(ma_100_days, 'b', label='MA100')
plt.legend()
st.pyplot(fig2)

st.subheader('Stock Price with MA100 vs MA200')
ma_200_days = data['Close'].rolling(200).mean()
fig3 = plt.figure(figsize=(8, 6))
plt.plot(data['Close'], 'g', label='Stock Price')
plt.plot(ma_100_days, 'b', label='MA100')
plt.plot(ma_200_days, 'r', label='MA200')
plt.legend()
st.pyplot(fig3)


# Predict test data and rescale
@st.cache_data
def predict_test_data(model, data_test_scaled, _scaler):
    """Predict on test data and rescale."""
    x = []
    y = []

    for i in range(100, data_test_scaled.shape[0]):
        x.append(data_test_scaled[i - 100:i])
        y.append(data_test_scaled[i, 0])

    x, y = np.array(x), np.array(y)

    # Predict on test data
    predict = model.predict(x)

    # Rescale predictions back to the original scale using scaler's scale_ attribute
    scale = 1 / _scaler.scale_[0]  # Correctly access scale_ instead of scale
    predict = predict * scale
    y = y * scale

    return predict, y


# Run predictions on the test data
predict, y = predict_test_data(model, data_test_scaled, scaler)

st.subheader('Original Price vs Predicted Price')
fig4 = plt.figure(figsize=(8, 6))
plt.plot(predict, 'r', label='Predicted Price')
plt.plot(y, 'g', label='Original Price')
plt.xlabel('Time')
plt.ylabel('Price')
plt.legend()
st.pyplot(fig4)


# Simulate market-like predicted prices with added volatility
@st.cache_data
def simulate_future_prices(model, data_test_scaled, _scaler, days=1560):
    """
    Simulate market-like predicted prices by adding randomness (volatility).
    """
    future_input = data_test_scaled[-100:].reshape(1, -1, 1)
    future_predictions = []

    for _ in range(days):
        # Model raw prediction
        next_pred = model.predict(future_input, verbose=0)[0, 0]
        
        # Simulate volatility with added randomness
        volatility_factor = np.random.normal(0, 0.005)  # Simulate small market fluctuations
        simulated_price = next_pred + volatility_factor

        # Update the rolling window for prediction
        future_input = np.roll(future_input, -1, axis=1)
        future_input[0, -1, 0] = simulated_price
        
        # Rescale prediction to its original price scale
        simulated_price_rescaled = simulated_price * (1 / scaler.scale_[0])
        future_predictions.append(simulated_price_rescaled)

    return np.array(future_predictions)


# Predict the next 6 years of stock prices
st.subheader('Predicted Stock Prices for the Next 6 Years')
future_predictions = simulate_future_prices(model, data_test_scaled, scaler, days=1560)

# Smooth prediction using rolling mean to make it "market-like"
smoothed_future_predictions = pd.Series(future_predictions).rolling(window=30, min_periods=1).mean()

# Create dates for plotting
future_dates = pd.date_range(start=data.index[-1], periods=1561, freq='D')[1:]

# Visualize predictions along with historical stock data
fig5 = plt.figure(figsize=(12, 6))
plt.plot(data.index, data['Close'], label='Historical Prices', color='blue')
plt.plot(future_dates, smoothed_future_predictions, label='Predicted Prices', color='red')
plt.title(f"{stock} Stock Price Prediction for the Next 6 Years")
plt.xlabel('Date')
plt.ylabel('Price')
plt.legend()
st.pyplot(fig5)
