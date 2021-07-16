// Image Slider 
const menu = document.querySelector('.menu');
const navLinks = document.querySelector('.nav-links');
menu.addEventListener('click', () => {
    navLinks.classList.toggle('show');
});

var i = 0;
var images = [];
var time = 2000;

//image list

images[0] = 'assets/solar.jpg';
images[1] = 'assets/cctv.jpg';
images[2] = 'assets/shop.jpg';
// images[3] = 'xyz.jpg';

//function to change image

function changeImage(){
    //set a default image
    document.slide.src = images[i];

    if(i < images.length - 1){
        i++;
    } else {
        i = 0;
    }
    setTimeout("changeImage()", time);
}



// Modal
// Get the modal
const modals = document.querySelectorAll("#price_modal");
// Get the button that opens the modal
const btns = document.querySelectorAll('#setprice');
// Get the <span> element that closes the modal
const closeBtns = document.querySelectorAll(".close-btn");

// When the user clicks the button, open the modal of that button

btns.forEach((btn, i) => {
    btn.addEventListener('click', () => {
        modals[i].style.display = "flex"; 
    })
});


// When the user clicks on <span> (x), close the modal
closeBtns.forEach((closeBtn, i) => {
    closeBtn.addEventListener('click', () => {
        modals[i].style.display = "none"; 
    })
});
// closeBtn.onclick = function() {
//   modal.style.display = "none";
// }

// When the user clicks anywhere outside of the modal, close it
modals.forEach(modal => {
    window.onclick = function(event) {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      }
});
// window.onclick = function(event) {
//   if (event.target == modal) {
//     modal.style.display = "none";
//   }
// }
// Modal Ends


window.onload = changeImage;
// Image Slider Ends


// ITem Upload 
// set form display onload based on selected value
window.addEventListener('load', function() {
    const itemType = document.querySelector('.item_type');
    formDisplay();
});

// toggle Others form view

const itemType = document.querySelector('.item_type');
const allFields = document.querySelectorAll('.fields_toggle');
const pcFields = document.querySelectorAll('#pc_fields');

itemType.addEventListener("change", () => {
    formDisplay();

});

function formDisplay() {
    if (!itemType.value) {
        allFields.forEach(field => {
            field.style["display"] = "none";
        });
    }else if(itemType.value == "computer" ) {
        allFields.forEach(field => {
            field.style["display"] = "";
        })
    }else if(itemType.value == "phone" ) {
        allFields.forEach(field => {
            field.style["display"] = "";
        })
    }else if(itemType.value == "others" ) {
        allFields.forEach(field => {
            field.style["display"] = "";
        })
        pcFields.forEach(field => {
            field.style["display"] = "none";
        })
    }
}
// ITem Upload Ends

