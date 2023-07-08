function updateTime() {
  // Get the element with id "time"
  const timeElement = document.getElementById("time");

  // Get the current time
  const currentTime = new Date();

  // Extract hours, minutes, and seconds from the current time
  const hours = currentTime.getHours();
  const minutes = currentTime.getMinutes();
  const seconds = currentTime.getSeconds();

  // Format the time as HH:MM:SS
  const formattedTime = `${hours}:${minutes}:${seconds}`;

  // Set the formatted time as the content of the timeElement
  timeElement.textContent = formattedTime;
}

function setGreeting() {
  // Get the element with id "greetings"
  const greetingElement = document.getElementById("greetings");

  // Get the current time
  const currentTime = new Date();

  // Get the current hour from the current time
  const currentHour = currentTime.getHours();

  let greeting = "";

  // Determine the appropriate greeting based on the current hour
  if (currentHour >= 5 && currentHour < 12) {
      greeting = "Good Morning!";
  } else if (currentHour >= 12 && currentHour < 18) {
      greeting = "Good Afternoon!";
  } else {
      greeting = "Good Evening!";
  }

  // Set the greeting as the content of the greetingElement
  greetingElement.textContent = greeting;
}

// Update time every second
setInterval(updateTime, 1000);

// Set initial greeting and update it every minute
setGreeting();
setInterval(setGreeting, 60000);

// Add a click event listener to the element with class "sidenav-toggle"
document.querySelector(".sidenav-toggle").addEventListener('click', () => {
  // Toggle the "min-side-menu" class on the "side-menu" element
  document.querySelector(".side-menu").classList.toggle("min-side-menu");
});
