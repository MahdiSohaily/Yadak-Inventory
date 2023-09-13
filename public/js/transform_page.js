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

      // Extract and display the content of sibling <tr> elements
      let values = [];
      tdElements.forEach(function (td, index) {
        values.push(td.textContent);
      });

      print_result.innerHTML += createTemplate(values, i + 1);
    }
  }
}

function createTemplate(values, counter) {
  let template = `<tr class="list-item">`;

  const partNumber = values[1];
  const brand = values[2];
  const description = values[3];
  const inventory = values[6];
  const amount = values[7];
  const seller = values[8];
  const deliver = values[9];
  const date = values[10];

  template += `<td class="tableitem">${counter}</td>`;
  template += `<td class="tableitem">${partNumber}</td>`;
  template += `<td class="tableitem">${brand}</td>`;
  template += `<td class="tableitem">${description}</td>`;
  template += `<td class="tableitem">${inventory}</td>`;
  template += `<td class="tableitem">${amount}</td>`;
  template += `<td class="tableitem">${seller}</td>`;
  template += `<td class="tableitem">${deliver}</td>`;
  template += `<td class="tableitem">${date}</td>`;

  template += `</tr>`;
  return template;
}
