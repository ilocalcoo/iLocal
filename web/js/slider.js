var slider = document.getElementById("round_range");
var output = document.getElementById("range_text");
output.innerHTML = slider.value + " км"; // Display the default slider value

// Update the current slider value (each time you drag the slider handle)
slider.oninput = function() {
    output.innerHTML = this.value === '11' ? "более 10 км" : this.value + " км";

}
