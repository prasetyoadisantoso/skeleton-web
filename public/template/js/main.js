var timeDisplay = document.getElementById("time");


function refreshTime() {
  var dateString = new Date().toLocaleString("en-US", {timeZone: "Asia/Makassar"});
  var formattedString = dateString.replace(", ", " - ");
  timeDisplay.innerHTML = formattedString;
}

setInterval(refreshTime, 1000);
