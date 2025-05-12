// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize all popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Add fade-in animation to cards
    document.querySelectorAll('.card').forEach(function(card) {
        card.classList.add('fade-in');
    });

    // Handle movie search form submission
    const searchForm = document.querySelector('form[action*="search"]');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const query = this.querySelector('input[name="query"]').value.trim();
            const genre = this.querySelector('select[name="genre"]').value;
            
            if (!query && !genre) {
                e.preventDefault();
                alert('Please enter a search term or select a genre');
            }
        });
    }

    // Handle seat selection
    const seatButtons = document.querySelectorAll('.seat-btn:not([disabled])');
    if (seatButtons.length > 0) {
        seatButtons.forEach(button => {
            button.addEventListener('click', function() {
                const seat = this.dataset.seat;
                const index = selectedSeats.indexOf(seat);

                if (index === -1) {
                    selectedSeats.push(seat);
                    this.classList.remove('btn-outline-primary');
                    this.classList.add('btn-primary');
                } else {
                    selectedSeats.splice(index, 1);
                    this.classList.remove('btn-primary');
                    this.classList.add('btn-outline-primary');
                }

                updateBookingSummary();
            });
        });
    }

    // Handle booking form submission
    const bookingForm = document.getElementById('bookingForm');
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            const selectedSeats = JSON.parse(document.getElementById('selectedSeatsInput').value);
            
            if (selectedSeats.length === 0) {
                e.preventDefault();
                alert('Please select at least one seat');
            }
        });
    }

    // Handle movie deletion confirmation
    const deleteButtons = document.querySelectorAll('[data-bs-target^="#deleteMovieModal"]');
    if (deleteButtons.length > 0) {
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const movieTitle = this.closest('tr').querySelector('td:nth-child(2)').textContent;
                const modal = document.querySelector(this.dataset.bsTarget);
                modal.querySelector('.modal-body p').textContent = `Are you sure you want to delete "${movieTitle}"?`;
            });
        });
    }

    // Handle booking cancellation confirmation
    const cancelButtons = document.querySelectorAll('[data-bs-target^="#cancelModal"]');
    if (cancelButtons.length > 0) {
        cancelButtons.forEach(button => {
            button.addEventListener('click', function() {
                const bookingId = this.closest('tr').querySelector('td:first-child').textContent;
                const modal = document.querySelector(this.dataset.bsTarget);
                modal.querySelector('.modal-title').textContent = `Cancel Booking ${bookingId}`;
            });
        });
    }

    // Add smooth scrolling to all links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Handle responsive navigation
    const navbarToggler = document.querySelector('.navbar-toggler');
    if (navbarToggler) {
        navbarToggler.addEventListener('click', function() {
            document.querySelector('.navbar-collapse').classList.toggle('show');
        });
    }

    // Add loading state to buttons
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
            }
        });
    });
});

// Function to update booking summary
function updateBookingSummary() {
    const selectedSeatsDiv = document.getElementById('selectedSeats');
    const selectedSeatsInput = document.getElementById('selectedSeatsInput');
    const ticketCountSpan = document.getElementById('ticketCount');
    const totalPriceSpan = document.getElementById('totalPrice');
    const bookButton = document.getElementById('bookButton');
    const pricePerTicket = parseFloat(document.querySelector('meta[name="price-per-ticket"]').content);
    
    const count = selectedSeats.length;
    const total = count * pricePerTicket;

    if (count > 0) {
        selectedSeatsDiv.innerHTML = selectedSeats.join(', ');
        bookButton.disabled = false;
    } else {
        selectedSeatsDiv.innerHTML = '<span class="text-muted">No seats selected</span>';
        bookButton.disabled = true;
    }

    ticketCountSpan.textContent = count;
    totalPriceSpan.textContent = `$${total.toFixed(2)}`;
    selectedSeatsInput.value = JSON.stringify(selectedSeats);
}

// Function to show notification
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
    notification.style.zIndex = '1050';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 5000);
}

// Function to format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

// Function to format date
function formatDate(date) {
    return new Intl.DateTimeFormat('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    }).format(new Date(date));
}

// Function to format time
function formatTime(time) {
    return new Intl.DateTimeFormat('en-US', {
        hour: 'numeric',
        minute: 'numeric',
        hour12: true
    }).format(new Date(`2000-01-01T${time}`));
} 