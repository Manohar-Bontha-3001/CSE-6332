// 

// Example JavaScript code
document.addEventListener("DOMContentLoaded", function() {
    // Execute JavaScript code when the DOM is fully loaded
    console.log("DOM loaded");

    // Example: Change the background color of the body
    document.body.style.backgroundColor = "#f0f0f0";

    // Add event listener to a button (example)
    var button = document.getElementById("myButton");
    button.addEventListener("click", function() {
        alert("Button clicked!");
    });
});
