// get all "Load More" buttons
var loadMoreButtons = document.querySelectorAll('.kp-load-more');

// add click event listener to each button
loadMoreButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        // get the post id from the button
        var postId = this.dataset.postId;

        // show the hidden content for the post
        var hiddenExcerpt = document.querySelector('.kp-hidden-excerpt[data-post-id="' + postId + '"]');
        var hiddenContent = document.querySelector('.kp-hidden-content[data-post-id="' + postId + '"]');
        hiddenContent.style.display = (hiddenContent.style.display === 'none') ? 'block' : 'none';
        hiddenExcerpt.style.display = (hiddenContent.style.display === 'none') ? 'block' : 'none';
    });
});

// select all the folder buttons
const folderButtons = document.querySelectorAll('.kp-folder-name-button');

// select all the posts sections
const folderSections = document.querySelectorAll('.kp-folder-section');

// add a click event listener to each button
folderButtons.forEach(button => {
    button.addEventListener('click', event => {

        // toggle the active class on the button
        button.classList.add('active');

        // remove the active class from all the other buttons
        folderButtons.forEach(otherButton => {
            if (otherButton !== button) {
                otherButton.classList.remove('active');
            }
        });

        // get the term ID of the clicked button
        const termId = button.dataset.term;

        // show the posts section with the same term ID as the clicked button
        folderSections.forEach(section => {
            if (section.dataset.term === termId) {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        });
    });
});

const sortDropdown = document.querySelector('.kp-sort-dropdown');

sortDropdown.addEventListener('change', event => {
    const sortOption = event.target.value;

    // Sort the posts based on the selected option
    if (sortOption === 'date-asc') {
        // Sort the posts by date in ascending order
    } else if (sortOption === 'date-desc') {
        // Sort the posts by date in descending order
    }
    // Add handling for other sorting options
});

