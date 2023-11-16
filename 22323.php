<!DOCTYPE html>
<html>

<head>
    <title>ES6 with jQuery Example</title>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include iziModal CSS and JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.5.1/css/iziModal.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.5.1/js/iziModal.min.js"></script>
</head>

<body>

    <h1>ES6 with jQuery Example</h1>

    <!-- Modal Trigger Button -->
    <button id="getDataBtn">Open Modal</button>

    <!-- The Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="dataContainer"></div>
            <div class="modal-counters">
                <div>Entry: <span id="entryCounter">0</span></div>
                <div>ID: <span id="idCounter">0</span></div>
            </div>
            <div class="modal-buttons">
                <button id="prevBtn">Previous</button>
                <button id="nextBtn">Next</button>
            </div>
        </div>
    </div>

    <script>
        let currentDataIndex = 0;
        let modalData = []  ;

        // Function to fetch data from the server using AJAX
        const fetchDataFromServer = () => {
            return $.ajax({
                url: "data.php",
                type: "POST", // Use POST request instead of GET
                dataType: "json"
            });
        };

        // Function to display the current data in the modal
        const displayDataInModal = () => {
            const modalDataContainer = $("#dataContainer");
            modalDataContainer.empty(); // Clear existing content

            const data = modalData[currentDataIndex];
            const counter = currentDataIndex + 1; // Counter starts from 1
            const layout = `
            <div class="data-entry">
            <h2>Entry ${counter}</h2>
            <p>ID: ${data.id}</p>
            <p>Content: ${data.content}</p>
            <!-- Add any other layout elements or data from the database -->
            </div>
      `;

            modalDataContainer.append(layout);

            // Update the counters
            $("#entryCounter").text(counter);
            $("#idCounter").text(data.id);
        };

        // Function to show the next data
        const showNextData = () => {
            if (currentDataIndex < modalData.length - 1) {
                currentDataIndex++;
                displayDataInModal();
            }
        };

        // Function to show the previous data
        const showPrevData = () => {
            if (currentDataIndex > 0) {
                currentDataIndex--;
                displayDataInModal();
            }
        };

        // Function to open the modal   and display the initial data
        const openModal = () => {
            $("#myModal").iziModal(); // Initialize iziModal

            // Fetch data from the server and then display the first data in the modal
            fetchDataFromServer().then((data) => {
                modalData = data;
                displayDataInModal();

                // Bind the "Next" and "Previous" button click events
                $("#myModal").on('click', '#nextBtn', showNextData);
                $("#myModal").on('click', '#prevBtn', showPrevData);

                // Open the modal using iziModal
                $("#myModal").iziModal("open");
            }).catch((error) => {
                console.error("Error fetching data:", error);
                // Handle error (display an error message, etc.)
            });
        };

        // Event listener for the "Open Modal" button
        $(document).ready(function() {
            $("#getDataBtn").on("click", openModal);
        });
    </script>

</body>

</html>