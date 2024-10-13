// JavaScript to open and close the side panel
function myFunction() {
    var x = document.getElementById("mySidePanel");
    if (x.style.display === "block") {
        x.style.display = "none";
        closePanel();
    } else {
        x.style.display = "block";
        openPanel(); 
    }
}
    
function openPanel() {
    document.getElementById("mySidePanel").style.width = "250px";
    document.querySelector('.main-content').style.marginLeft = "250px";
    document.querySelector('.header-panel').style.marginLeft = "250px";
}    


function closePanel() {
    document.getElementById("mySidePanel").style.width = "0";
    document.querySelector('.main-content').style.marginLeft = "0";
    document.querySelector('.header-panel').style.marginLeft = "0";
}