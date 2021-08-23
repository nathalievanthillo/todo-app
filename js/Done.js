var doneButtons = document.getElementsByClassName("statusDone");
 
//als er op button wordt geklikt wordt onderstaande code uitgevoerd

for (let i = 0; i < doneButtons.length; i++) { //alle buttons selecteren en in done button steken 

    doneButtons[i].addEventListener("click", function(e) { //in event listener toevoegen aan elke button

        var taskId = e.path[0].dataset.taskid;
    
        var formData = new FormData();
    
        formData.append("taskId", taskId);
    
        fetch("./ajax_commands/setTaskDone.php", {
            method: "POST",
            body:formData
        })
            .then(response => response.json())
            .then(result => {
                var status = document.querySelectorAll(".status");
                status[i].outerText = "done";
                console.log(status);
            })
    
            .catch(error => {
                console.error("Error:", error);
            });     
            
        e.preventDefault();
        
    })
  }



