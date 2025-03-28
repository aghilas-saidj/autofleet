# Use an official Node.js runtime as a parent image
FROM node:18-alpine 

# Set the working directory inside the container
WORKDIR /app 

# Copy package.json and package-lock.json
COPY package*.json ./

# Install dependencies
RUN npm install

# Copy the entire project (except files in .dockerignore)
COPY . . 

# Build the Vue.js app
RUN npm run build

# Use an Nginx image to serve the built app
FROM nginx:alpine 

# Copy the built files from the previous stage
COPY --from=0 /app/dist /usr/share/nginx/html 

# Expose port 80
EXPOSE 80 

# Start Nginx server
CMD ["nginx", "-g", "daemon off;"]
