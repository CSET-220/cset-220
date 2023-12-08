document.addEventListener('DOMContentLoaded', () => {
    // patientId is stored in a global variable in the view
    const familyCodeForm = document.getElementById('family-code-form');

    familyCodeForm.addEventListener('submit', (event) => {
        event.preventDefault();
        const patientId = document.getElementById('patient-id').value;
        const familyCode = document.getElementById('family-code').value;
        const url = `/api/family/confirm_family`;
        const alert = document.getElementById('alert');
        const dismissBtn = document.getElementById('dismiss-btn');

        const dismiss = new Dismiss(alert, dismissBtn);

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ 'patient_id': patientId, 'family_code': familyCode }),
        }) 
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    window.location.href = `/family/${data.user_id}`
                }
                else {
                    const alertMessage = document.getElementById('alert-message');
                    alertMessage.textContent = data.message;
                    alert.classList.remove('opacity-0', 'hidden');
                    alert.classList.add('flex');
                }
            })
            .catch(error => {
                console.log('We got an error: ', error);
            })
    })
});