<template>
  <div class="progress-circle">
    <svg width="100" height="100">
      <!-- Background Circle -->
      <circle cx="50" cy="50" r="45" class="progress-bg"></circle>
      <!-- Rotating Progress Circle -->
      <circle cx="50" cy="50" r="45" class="progress-bar"></circle>
    </svg>
  </div>
</template>

<script setup></script>

<style scoped>
.progress-circle {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100px;
  height: 100px;
}

svg {
  transform: rotate(-90deg);
}

.progress-bg {
  fill: none;
  stroke: #e0e0e0;
  stroke-width: 8;
}

.progress-bar {
  fill: none;
  stroke: #007bff;
  stroke-width: 8;
  stroke-linecap: round;
  stroke-dasharray: 283; /* Full circle */
  stroke-dashoffset: 0; /* Start from 0 */
  animation: moveStroke 2s linear infinite;
}

/* Proper stroke movement animation */
@keyframes moveStroke {
  0% {
    stroke-dashoffset: 283;
  }
  100% {
    stroke-dashoffset: 0;
  }
}
</style>
