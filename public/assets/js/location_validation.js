document.addEventListener("DOMContentLoaded", function () {
    // Selecting form and input elements
    const form = document.querySelector("#locationForm");
    const projectSelect = document.getElementById("project_id");
    const postcodeInput = document.getElementById("postcode");
    // ... Other input elements ...

    // Function to display error messages
    const showError = (field, errorText) => {
        const formGroup = field.closest(".form-group");
        formGroup.classList.add("has-error");
        const errorElement = formGroup.querySelector(".error-text");
        errorElement.innerText = errorText;
    };

    // Function to clear error messages
    const clearError = (field) => {
        const formGroup = field.closest(".form-group");
        formGroup.classList.remove("has-error");
        const errorElement = formGroup.querySelector(".error-text");
        errorElement.innerText = "";
    };

    // Handling form submission event
    form.addEventListener("submit", (e) => {
        e.preventDefault();

        // Clearing previous error messages
        document.querySelectorAll(".form-group").forEach(formGroup => {
            formGroup.classList.remove("has-error");
            formGroup.querySelector(".error-text").innerText = "";
        });

        // Validation for project
        if (projectSelect.value === "") {
            showError(projectSelect, "Select a project");
        } else {
            clearError(projectSelect);
        }

        // Validation for postcode
        const postcodePattern = /^[0-9]{5}$/;
        if (!postcodePattern.test(postcodeInput.value)) {
            showError(postcodeInput, "Enter a valid postcode (5 digits)");
        } else {
            clearError(postcodeInput);
        }

        // ... Repeat for other fields ...

        // Checking for any remaining errors before form submission
        const errorFormGroups = form.querySelectorAll(".form-group.has-error");
        if (errorFormGroups.length > 0) return;

        // Submitting the form
        form.submit();
    });
});
