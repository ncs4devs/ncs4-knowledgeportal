// get all "Load More" buttons
var loadMoreButtons = document.querySelectorAll('.kp-load-more');

// add click event listener to each button
loadMoreButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        // get the post id from the button
        var postId = this.dataset.postId;

        // show the hidden content for the post
        var hiddenExcerpts = document.querySelectorAll('.kp-hidden-excerpt[data-post-id="' + postId + '"]');
        var hiddenContents = document.querySelectorAll('.kp-hidden-content[data-post-id="' + postId + '"]');
        var hidden = '';
        hiddenExcerpts.forEach(function(hiddenExcerpt) {
            hiddenExcerpt.style.display = (hiddenExcerpt.style.display === 'none') ? 'block' : 'none';
            hidden = hiddenExcerpt.style.display;
        })
        hiddenContents.forEach(function(hiddenContent) {
            hiddenContent.style.display = (hidden === 'none') ? 'block' : 'none';
        })
        
        if (this.innerHTML === 'load more...') {
            this.innerHTML = 'show less';
          } else {
            this.innerHTML = 'load more...';
          }
          
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
const folderPostsDateASC = document.getElementById('kp-folder-posts-date-asc');
const folderPostsDateDESC = document.getElementById('kp-folder-posts-date-desc');

sortDropdown.addEventListener('change', event => {
    const sortOption = event.target.value;

    // Sort the posts based on the selected option
    if (sortOption === 'date-asc') {
        // Sort the posts by date in ascending order
        folderPostsDateASC.style.display = 'block';
        folderPostsDateDESC.style.display = 'none';
    } else if (sortOption === 'date-desc') {
        // Sort the posts by date in descending order
        folderPostsDateASC.style.display = 'none';
        folderPostsDateDESC.style.display = 'block';
    }
    // Add handling for other sorting options
});
