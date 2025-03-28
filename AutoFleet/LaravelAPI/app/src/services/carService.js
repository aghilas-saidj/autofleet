const axios = require('axios');

const API_URL = 'http://127.0.0.1:8000/api/cars';

/**
 * Fetches cars from the API.
 * @param {Object} options - Options for fetching cars.
 * @param {string} options.from - Start date for the availability filter.
 * @param {string} options.to - End date for the availability filter.
 * @returns {Promise<Array>} - A promise that resolves to the array of cars.
 */

const getCars = async ({ from, to } = {}) => {
  try {
    // Construct the request parameters
    const params = {};
    if (from) params.from = from; // Only add the 'from' parameter if it exists
    if (to) params.to = to; // Only add the 'to' parameter if it exists

    // Make the API request with the parameters
    const response = await axios.get(API_URL, { params });

    // Log the fetched data for debugging
     console.log("Fetched cars data:", JSON.stringify(response.data, null, 2));
    
    // Check if the response structure is as expected and return data
    if (response.data && Array.isArray(response.data.original)) {
      return response.data.original; // Return the original data array
    } else {
      console.error("Unexpected response structure:", response.data);
      return []; // Return an empty array if the structure is not as expected
    }




  } catch (error) {
    console.error("Error fetching cars:", error);
    throw error; // Throw the error to handle it in the component
  }
};

module.exports = { getCars };
