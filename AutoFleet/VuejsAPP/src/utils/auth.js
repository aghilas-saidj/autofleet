// src/utils/auth.js

//import router from '@/router'; // Import Vue Router to redirect the user

// Function to handle Unauthorized errors
export const handleUnauthorizedError = (error) => {
  // Ensure error.response exists before accessing it
  if (error.response) {
    // Check for 403 error
    if (error.response.status === 403) {
      // Check if it's an 'Admin only' error
      if (error.response.data?.message === "Unauthorized - Admins only") {
        console.log("Unauthorized - Admins only");
        // Redirect to login page
       // router.push("/login");
      }
    } else {
      console.error("Unhandled error:", error.response);
    }
  } else {
    console.error("Network error or unexpected issue:", error);
  }
};
