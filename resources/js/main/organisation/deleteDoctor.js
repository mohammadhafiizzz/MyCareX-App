document.addEventListener('DOMContentLoaded', function () {
    const removeDoctorBtn = document.getElementById('removeDoctorBtn');
    const deleteDoctorModal = document.getElementById('deleteDoctorModal');
    const closeDeleteModal = document.getElementById('closeDeleteModal');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const confirmIcInput = document.getElementById('confirm_ic_number');
    const icError = document.getElementById('ic_error');

    const isMiddleSegmentValid = (value) => {
        if (value.length < 8) return false;
        const segment = value.slice(6, 8);
        if (!/^\d{2}$/.test(segment)) return false;
        const numericValue = parseInt(segment, 10);
        return numericValue >= 1 && numericValue <= 15;
    };

    const formatIC = (val) => {
        let value = val.replace(/\D/g, '');
        if (value.length > 12) value = value.slice(0, 12);
        
        let formatted = value;
        if (value.length > 6) formatted = value.slice(0, 6) + '-' + value.slice(6);
        if (value.length > 8) formatted = value.slice(0, 6) + '-' + value.slice(6, 8) + '-' + value.slice(8);
        return { formatted, raw: value };
    };

    if (confirmIcInput) {
        confirmIcInput.addEventListener('input', function(e) {
            const { formatted, raw } = formatIC(e.target.value);
            e.target.value = formatted;
            e.target.dataset.rawValue = raw;

            if (raw.length > 0) {
                icError.classList.remove('hidden');
                const lengthValid = raw.length === 12;
                const middleValid = isMiddleSegmentValid(raw);
                
                if (lengthValid && middleValid) {
                    icError.innerHTML = '<i class="fas fa-check-circle text-green-600 mr-1"></i><span class="text-green-600">Valid IC format</span>';
                } else if (!lengthValid) {
                    icError.innerHTML = '<i class="fas fa-exclamation-circle text-amber-600 mr-1"></i><span class="text-amber-600">IC number must be 12 digits.</span>';
                } else {
                    icError.innerHTML = '<i class="fas fa-exclamation-circle text-amber-600 mr-1"></i><span class="text-amber-600">Digits in the middle must be between 01 and 15</span>';
                }
            } else {
                icError.classList.add('hidden');
            }
        });
    }

    if (removeDoctorBtn) {
        removeDoctorBtn.addEventListener('click', function () {
            deleteDoctorModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
    }

    if (closeDeleteModal) {
        closeDeleteModal.addEventListener('click', function () {
            deleteDoctorModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            confirmIcInput.value = '';
            confirmIcInput.dataset.rawValue = '';
            icError.classList.add('hidden');
        });
    }

    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', function () {
            const doctorId = this.getAttribute('data-doctor-id');
            const icRaw = confirmIcInput.dataset.rawValue || confirmIcInput.value.replace(/\D/g, '');

            if (!icRaw) {
                icError.innerHTML = '<i class="fas fa-exclamation-circle text-red-600 mr-1"></i><span class="text-red-600">Please enter the IC number.</span>';
                icError.classList.remove('hidden');
                return;
            }

            if (icRaw.length !== 12) {
                icError.innerHTML = '<i class="fas fa-exclamation-circle text-red-600 mr-1"></i><span class="text-red-600">IC number must be 12 digits.</span>';
                icError.classList.remove('hidden');
                return;
            }

            if (!isMiddleSegmentValid(icRaw)) {
                icError.innerHTML = '<i class="fas fa-exclamation-circle text-red-600 mr-1"></i><span class="text-red-600">Digits 7-8 of the IC number must be between 01 and 15.</span>';
                icError.classList.remove('hidden');
                return;
            }

            // Disable button and show loading state
            confirmDeleteBtn.disabled = true;
            confirmDeleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Removing...';

            fetch(`/organisation/doctors/delete/${doctorId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    ic_number: icRaw
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    icError.innerHTML = `<i class="fas fa-exclamation-circle text-red-600 mr-1"></i><span class="text-red-600">${data.message || 'An error occurred.'}</span>`;
                    icError.classList.remove('hidden');
                    confirmDeleteBtn.disabled = false;
                    confirmDeleteBtn.innerHTML = 'Remove Permanently';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                icError.innerHTML = '<i class="fas fa-exclamation-circle text-red-600 mr-1"></i><span class="text-red-600">An unexpected error occurred. Please try again.</span>';
                icError.classList.remove('hidden');
                confirmDeleteBtn.disabled = false;
                confirmDeleteBtn.innerHTML = 'Remove Permanently';
            });
        });
    }
});