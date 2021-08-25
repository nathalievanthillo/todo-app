var commentBoxes = document.getElementsByClassName("commentBox");
var comments = document.getElementsByClassName("comments");
var inputFields = document.getElementsByClassName("commentBoxText"); //inputfields variable en commentBoxText is klasse naam

function addComment(eventArgs){
    var taskId = eventArgs.path[0].dataset.taskid;
    var commentText = eventArgs.path[0].previousElementSibling.value;
    
    var formData = new FormData();

    formData.append("taskId", taskId);
    formData.append("commentText", commentText);

    fetch("./ajax_commands/addCommentToTask.php", {
        method: "POST",
        body:formData
    })
        .then(response => response.json())
        .then(result => {

            var comment = document.createElement('p'); //p tag
            comment.innerHTML=commentText;

            comments[eventArgs.path[0].dataset.counter].appendChild(comment);

            inputFields[eventArgs.path[0].dataset.counter].value="";
            
            
        }) 
        .catch(error => {
            console.error("Error:", error);
        });


    
    
}

var commentBoxes = document.getElementsByClassName("commentBox");//zoeken naar alle divs met klasse commentBox 

for(i=0; i<commentBoxes.length; i++){
    commentBoxes[i].getElementsByClassName('commentBoxButton')[0].onclick = addComment; //binnen commentBox div zoeken naar de commentbox button
}
