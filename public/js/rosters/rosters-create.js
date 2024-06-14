var caregiverSelects = document.querySelectorAll("select[name^='caregiver']");

function updateCaregiverSelects() {
    var selectedValues = Array.from(caregiverSelects, select => select.value);

    caregiverSelects.forEach(select => {
        const currentValue = select.value;
        select.querySelectorAll("option").forEach(option => {
            option.hidden = selectedValues.includes(option.value) && option.value !== currentValue;
        });
    });
}

caregiverSelects.forEach(select => select.addEventListener("change", updateCaregiverSelects));
