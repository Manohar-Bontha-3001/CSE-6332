
window.onload = function() {
  // Assuming you have retrieved user information from Azure Database
  var userData = {
    name: "Manohar Bontha",
    id: "1002091309"
  };

  // Update the user information in the header
  document.getElementById("username").textContent = userData.name;
  document.getElementById("userid").textContent = "ID no " + userData.id;
};
