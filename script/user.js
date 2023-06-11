let addUserDialog = document.getElementById("addUserDialog");
addUserDialog.style.display = "none";

let editUserDialog = document.getElementById("editUserDialog");
editUserDialog.style.display = "none";

let deleteUserDialog = document.getElementById("deleteUserDialog");
deleteUserDialog.style.display = "none";

function addUser(){
    let overlay = document.getElementById("overlay");
    overlay.style.display = "block";
    addUserDialog.style.display = "block";
    document.body.style.overflow = "hidden";
}

function editUser(code, full, name, lvl){
    let overlay = document.getElementById("overlay");
    overlay.style.display = "block";
    editUserDialog.style.display = "block";
    editUserDialog.style.zIndex  = "999";
    document.body.style.overflow = "hidden";

    document.getElementById("userCodeEdit").value = code;
    document.getElementById("userFullnameEdit").value = full;
    document.getElementById("usernameEdit").value = name;

    let userLevelSelect = document.getElementById("userLevel");
    let optionElements = userLevelSelect.options;
    for (let i = 0; i < optionElements.length; i++) {
        let option = optionElements[i];
        if (option.value === lvl) {
            option.selected = true;
            break;
        }
    }
}

function deleteUser(code, full, name, lvl){
    let overlay = document.getElementById("overlay");
    overlay.style.display = "block";
    deleteUserDialog.style.display = "block";
    deleteUserDialog.style.zIndex  = "999";
    document.body.style.overflow = "hidden";

    document.getElementById("userCodedelete").value = code;
    document.getElementById("userFullnamedelete").value = full;
    document.getElementById("usernamedelete").value = name;
    document.getElementById("userLevel").value = lvl;
}

function closeUser(){
    let overlay = document.getElementById("overlay");
    overlay.style.display = "none";
    addUserDialog.style.display = "none";
    editUserDialog.style.display = "none";
    deleteUserDialog.style.display = "none";
    document.body.style.overflow = "auto";
}