// CORE ELEMENTS FOR WORKING WITH PRINT MODAL
const print_modal = document.getElementById("print_modal");
const print_result = document.getElementById("print_result");

// ADD EVENT LISTENER TO THE MODAL TO CLOSE IT WHEN
print_modal.addEventListener("click", function (event) {
  // Check if the click target is the modal itself
  if (event.target === print_modal) {
    // If clicked on the modal, hide it
    print_modal.style.display = "none";
    print_result.innerHTML = null;
  }
});

// FUNCTION TO MAKE THE MODAL VISIBLE
function makePreview() {
  print_modal.style.display = "flex";
  // Get all checkboxes on the page
  const checkboxes = document.querySelectorAll('input[type="checkbox"]');

  // Loop through all checkboxes to check if they are selected
  const checkboxesCount = checkboxes.length;
  for (let i = 0; i < checkboxesCount; i++) {
    if (checkboxes[i].checked) {
      // If a checkbox is selected, add its value or any relevant data to the selectedCheckboxes array
      const row = checkboxes[i].closest("tr"); // Change this line to capture the data you need
      let tdElements = row.querySelectorAll("td:not(:last-child)");

      // Extract and display the content of sibling <td> elements
      let template = `<tr>`;
      tdElements.forEach(function (td, index) {
        if (index === 0) template += `<td class="text">${i + 1}</td>`;
        else template += `<td class="text">${td.textContent}</td>`;
      });
      template += `</td>`;

      print_result.innerHTML += template;
    }
  }
}
