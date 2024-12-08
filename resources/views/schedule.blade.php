<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Positions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 2px solid black;
        }

        th {
            background-color: #4CAF50;
            color: black;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4); /* Semi-transparent background */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 5px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Schedule</h1>
   
        <button type="button" id="newButton">New</button>

        <!-- Modal Structure -->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>New Schedule</h2>
                <form action="AddSched" method="Post">
                    @csrf
                    <label for="Date">Date:</label>
                    <input type="date" id="work_date" name="work_date"><br>
                    <label for="In">Time In:</label>
                    <input type="time" id="start_time" name="start_time" required><br>
                    <label for="Out">Time Out:</label>
                    <input type="time" id="end_time" name="end_time" required><br>
                    <button type="submit">Add Schedule</button>
                </form>
            </div>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Work Date</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schedule as $schedule)
                <tr>
                    <td>{{$schedule->work_date}}</td>
                    <td>{{$schedule->start_time }}</td>
                    <td>{{$schedule->end_time}}</td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </form>

    <script>
        // Get modal element
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("newButton");
        var span = document.getElementsByClassName("close")[0];
        btn.onclick = function() {
            modal.style.display = "block";
        }
        span.onclick = function() {
            modal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
