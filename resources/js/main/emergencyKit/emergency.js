document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('type');
    const recordSelect = document.getElementById('record_id');
    const recordContainer = document.getElementById('record-container');

    if (typeSelect) {
        typeSelect.addEventListener('change', function () {
            const type = this.value;
            
            // Reset record select
            recordSelect.innerHTML = '<option value="" disabled selected>Loading...</option>';
            recordContainer.classList.remove('hidden');

            // Fetch records
            // Ensure the route matches the one defined in web.php
            fetch(`/patient/emergency-kit/fetch-records?type=${type}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                recordSelect.innerHTML = '<option value="" disabled selected>Select a record...</option>';
                
                if (data.length === 0) {
                    const option = document.createElement('option');
                    option.text = "No available records found";
                    option.disabled = true;
                    recordSelect.add(option);
                } else {
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        
                        let text = item.name;
                        if (item.severity) text += ` (Severity: ${item.severity})`;
                        if (item.dosage) text += ` (${item.dosage} mg)`;
                        
                        option.text = text;
                        recordSelect.add(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                recordSelect.innerHTML = '<option value="" disabled selected>Error loading records</option>';
            });
        });
    }
});
