
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('stateSelect').addEventListener('change', function() {
        const stateId = this.value;
        console.log('State ID:', stateId);

        const districtSelect = document.getElementById('districtSelect');
        districtSelect.innerHTML = '<option value="">Select District</option>';

        if (stateId) {
            const url = `/get-districts?state_id=${stateId}`;
            console.log('Fetch URL:', url);

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    console.log('Fetched Data:', data);

                    data.forEach(district => {
                        const option = document.createElement('option');
                        option.value = district.id;
                        option.textContent = district.district_name;
                        districtSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                });
        }
    });
});
