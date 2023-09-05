function reseting() {
    if (confirm("Are you sure?")) {
        document.getElementById("blogTitle").value = "";
        document.getElementById("blogText").value = "";
    }
}
    
function displayError(message) {
    alert(message);
}

function checkForm(event) {
    var blogTitle = document.getElementById("blogTitle").value;
    var blogText = document.getElementById("blogText").value;
    if (blogText == "" && blogTitle == "") {
        document.getElementById("blogTitle").style.backgroundColor = "lightblue";
        document.getElementById("blogText").style.backgroundColor = "lightblue";
        alert("Title and Blog are both EMPTY");
        event.preventDefault();
        return false;
    } else if (blogTitle == "") {
        document.getElementById("blogTitle").style.backgroundColor = "lightblue";
        alert("Title is EMPTY");        
        event.preventDefault();
        return false;
    } else if (blogText == "") {
        document.getElementById("blogText").style.backgroundColor = "lightblue";
        alert("Blog Text is EMPTY");
        event.preventDefault();
        return false;
    } else {
        document.getElementById("blogForm").submit();
    }
} 
