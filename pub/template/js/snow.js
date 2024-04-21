// Function to create a new snowflake
var snowfallOn = true;

function createSnowflake() {
	// Create a new div
	var snowflake = document.createElement('div');

	// Add the "snowflake" class to the div
	snowflake.classList.add('snowflake');

	// Set the size and position of the snowflake
	snowflake.style.width = Math.random() * 10 + 'px';
	snowflake.style.height = snowflake.style.width;
	snowflake.style.left = Math.random() * 100 + '%';

	// Add the snowflake to the body of the document
	document.body.appendChild(snowflake);

	// Remove the snowflake after 10 seconds
	setTimeout(function() {
		snowflake.remove();
	}, 10000);
}

var snowflakeInterval;

// Function to start the snowfall
function startSnowfall() {
	snowflakeInterval = setInterval(createSnowflake, 100);
}

// Function to stop the snowfall
function stopSnowfall() {
	clearInterval(snowflakeInterval);
}

// Start the snowfall when the page loads
startSnowfall();

// Stop the snowfall when the page is hidden or loses focus
document.addEventListener('visibilitychange', function() {
	if (document.hidden) {
		stopSnowfall();
	} else {
		startSnowfall();
	}
});

// Function to toggle the snowfall on or off
function toggleSnowfall() {
	if (snowfallOn) {
		stopSnowfall();
	} else {
		startSnowfall();
	}
	snowfallOn = !snowfallOn;
}

// Add an event listener to the button
document.getElementById('toggleSnowfall').addEventListener('click', toggleSnowfall);
// Stop the snowfall when the page is hidden or loses focus
document.addEventListener('visibilitychange', function() {
	if (document.hidden) {
		stopSnowfall();
	} else {
		startSnowfall();
	}
});
window.addEventListener('blur', stopSnowfall);
window.addEventListener('focus', startSnowfall);