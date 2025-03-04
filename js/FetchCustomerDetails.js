document.addEventListener("DOMContentLoaded", () => {
    console.log("DOM fully loaded and parsed");

    window.readCustomer = async function(CUSTOMER_ID) {
        console.log("Fetching customer details for ID: ", CUSTOMER_ID);
        const customerDetails = document.getElementById("customerDetails");
        customerDetails.innerHTML = "<p class='text-primary'>Loading...</p>";

        try {
            // function encodes a URI component by replacing special characters with their corresponding percent-encoded values
            const response = await fetch(`ReadCustomer.php?id=${encodeURIComponent(CUSTOMER_ID)}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.text(); 
        console.log("Response received successfully", data);

        // Insert fetched data into the modal
        customerDetails.innerHTML = data;
    }
    catch (error) {
        console.error("Fetch error:", Error)
        customerDetails.innerHTML = '<p class="text-danger">Error fetching details.</p>'
    }
    
        // Show the modal (if not opened already)
        const modal = new bootstrap.Modal(document.getElementById("readCustomerModal"));
        modal.show();
    };
});
