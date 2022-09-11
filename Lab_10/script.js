//Asks for un and prints it and sets cookie "name" = name
function getUserName(){
    if (localStorage.getItem("name") != null) {
        document.cookie = "name=" + localStorage.getItem("name");
        document.getElementById('name').insertAdjacentText("afterbegin", localStorage.getItem("name") +"'s shopping list");
    } else {
     do {
            var name = window.prompt("Enter your name:");
            if (!/[^a-zA-Z]/.test(name)) {
                document.getElementById('name').insertAdjacentText("afterbegin", name +"'s shopping list");
                document.cookie = "name=" + name;
                localStorage.setItem("name", name);
                if (typeof localStorage == "undefined"){
                window.alert("Undefined local storage, the website will not work properly!");
                }
            } else {
                window.alert("Name can only contain letters from the English alphabet!");
            }
        } while (/[^a-zA-Z]/.test(name));
    }
    addRow();
}
//if user input is corrects adds item with quantity to the list
function addRow(){
        var t = document.getElementById("table");
        var n = t.rows.length;

        var listArr = getLocalList();
    if (listArr != null) {
            listArr = listArr.replace('{', '');
            listArr = listArr.replace('}', '');
            listArr = listArr.split(',');
            for (let i = 0; i < listArr.length; i++) {
                listArr[i] = listArr[i].replaceAll('"','');
                listArr[i] = listArr[i].replace('[','');
                listArr[i] = listArr[i].replace(']','');
                listArr[i] = listArr[i].replaceAll('\\','');
            }
    
        if (t.rows.length == 1) {
            for (let i = 0; i < listArr.length; i++) {
                var items = listArr[i].split(':');
        
                var row = t.insertRow(i + 1);
                
                row.setAttribute("id", i);
                row.setAttribute("onclick", "removeProduct(" + i + ")");
    
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
               
    
                cell1.innerHTML = i + 1 + ")";
                cell2.innerHTML = items[0];
                cell3.innerHTML = items[1];
                
            }
        } else if (listArr[n - 1]) {
            var row = t.insertRow(n);
            var items = listArr[n - 1].split(':');
            n = n - 1;
            row.setAttribute("id", n);
            row.setAttribute("onclick", "removeProduct(" + n + ")");
            
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
           

            cell1.innerHTML = (n+1) + ")";
            cell2.innerHTML = items[0];
            cell3.innerHTML = items[1];
        }
       
    }  
}
//if user input is correct gets the item name from form
function getItem() {
    var item = document.getElementById("addItem").value;
    if (!/[^a-zA-Z]/.test(item)) {
        return item;
    } else{
        window.alert("Item name can only contain letters from the English alphabet!");
        return null;
    }
}
//if user input is correct gets item quantity from form
function getQuantity(){
    var quantity = parseFloat(document.getElementById("quantity").value);
    if (!isNaN(quantity)) {
        return quantity;
    } else{
        window.alert("Quantity can only contain digits!");
        return null;
    }
}
//ads listed items to local list
function addLocalList() {
    var quant = getQuantity();
    var myList = getCookie('name');
    var item = getItem();
    if (item != null && item != "" && quant != null) {

        if (getLocalList() == null) {
            var list = {[item] : String(quant)};
            var  listString = JSON.stringify(list);
            localStorage.setItem(myList, listString);
        } else {
            var list = {[item] : String(quant)};
            var json = JSON.parse(getLocalList());
            var merge = Object.assign(json,list);
            var listString = JSON.stringify(merge);
            localStorage.setItem(myList, listString);
        }
        addRow();
    }
    document.getElementById("addItem").value = '';
    document.getElementById("quantity").value = '';
}
//returns the local storage associated with the current user
function getLocalList() {
    return localStorage.getItem(getCookie('name'));
}
//logs the user out
function userLogout() {
    localStorage.removeItem("name");
    location.reload();
}
//removes an item form the list
function removeProduct(itemId) {
    var listName = getCookie('name');
    var confirmation = confirm("Press 'OK' to remove item!");
    if (confirmation) {
        var newArr = [];
        var storage = JSON.parse(getLocalList());
        storage = JSON.stringify(storage);
        storage = storage.split(',');
        for (let i = 0; i < storage.length; i++) {
            if (i != itemId) {
                newArr.push(storage[i]);
            }
        }
        if (newArr.length == 0) {
            localStorage.removeItem(listName);
        } else{
           
            if (itemId == 0) {
                newArr[0] = '{' + newArr[0];
            } else if (itemId == storage.length - 1) {
                newArr[storage.length - 2] = newArr[storage.length - 2] + "}";
            }
          
            newArr = JSON.parse(newArr);
            newArr = JSON.stringify(newArr);

            localStorage.setItem(listName, newArr);
        }
    }
   // location.reload();
   for (let i = 0; i < storage.length; i++) {
     document.getElementById("table").deleteRow(itemId + 1);
   }

   var t = document.getElementById("table");
   var n = t.rows.length;

   var listArr = getLocalList();
if (listArr != null) {
       listArr = listArr.replace('{', '');
       listArr = listArr.replace('}', '');
       listArr = listArr.split(',');
       for (let i = 0; i < listArr.length; i++) {
           listArr[i] = listArr[i].replaceAll('"','');
           listArr[i] = listArr[i].replace('[','');
           listArr[i] = listArr[i].replace(']','');
           listArr[i] = listArr[i].replaceAll('\\','');
       }

   if (t.rows.length == 1) {
       for (let i = 0; i < listArr.length; i++) {
           var items = listArr[i].split(':');
   
           var row = t.insertRow(i + 1);
           
           row.setAttribute("id", i);
           row.setAttribute("onclick", "removeProduct(" + i + ")");

           var cell1 = row.insertCell(0);
           var cell2 = row.insertCell(1);
           var cell3 = row.insertCell(2);
          

           cell1.innerHTML = i + 1 + ")";
           cell2.innerHTML = items[0];
           cell3.innerHTML = items[1];
           
       }
   } else if (listArr[n - 1]) {
       var row = t.insertRow(n);
       var items = listArr[n - 1].split(':');
       n = n - 1;
       row.setAttribute("id", n);
       row.setAttribute("onclick", "removeProduct(" + n + ")");
       
       var cell1 = row.insertCell(0);
       var cell2 = row.insertCell(1);
       var cell3 = row.insertCell(2);
      

       cell1.innerHTML = (n+1) + ")";
       cell2.innerHTML = items[0];
       cell3.innerHTML = items[1];
   }
  
}  
    document.getElementById("table").refresh();
}

// this function is not my own and only used to look up the appropriate cookie needed to another function. Source: https://www.tutorialrepublic.com/javascript-tutorial/javascript-cookies.php
function getCookie(name) {
    // Split cookie string and get all individual name=value pairs in an array
    var cookieArr = document.cookie.split(";");
    
    // Loop through the array elements
    for(var i = 0; i < cookieArr.length; i++) {
        var cookiePair = cookieArr[i].split("=");
        
        /* Removing whitespace at the beginning of the cookie name
        and compare it with the given string */
        if(name == cookiePair[0].trim()) {
            // Decode the cookie value and return
            return decodeURIComponent(cookiePair[1]);
        }
    }
    
    // Return null if not found
    return null;
}