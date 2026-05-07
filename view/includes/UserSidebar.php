<?php
if (!defined('APP_RUNNING')) {
    header("Location: Index");
    exit();
}
?>
<style>
    #sidebar {
        float: left;
        width: 200px;
        background-color: #f8f9fa;
        padding: 20px;
        border-right: 1px solid #dee2e6;
        min-height: 100vh;
    }
    #sidebar ul {
        list-style-type: none;
        padding: 0;
    }
    #sidebar ul li {
        margin-bottom: 5px;
    }
    #sidebar ul li a {
        display: block;
        padding: 10px;
        background-color: #e9ecef;
        text-decoration: none;
        color: #333;
        border-radius: 5px;
        transition: 0.3s;
    }
    #sidebar ul li a:hover {
        background-color: #007bff;
        color: #fff;
    }
    #sidebar h2 {
        font-size: 1.2rem;
        text-align: center;
        margin-bottom: 20px;
    }
</style>

<div id="sidebar">
    <h2>Account Menu</h2>
    <ul>
        <li><a href="UserProfile">Dashboard</a></li>
        <li><a href="UserUpdate">Account Details</a></li>
        <li><a href="UserAddress">Address Book</a></li>
        <li><a href="UserTicket">Purchase Ticket</a></li>
        <li><a href="UserPurchase">Purchase History</a></li>
        <li><a href="UserVenueBook">Book Venue</a></li>
        <li><a href="UserVenueHistory">Booking History</a></li>
        <li><a href="UserComplaint">Complaint</a></li>
        <li><a href="UserQuery">Query</a></li>
        <li><a href="UserQuotation">Ask for Quotation</a></li>
        <li><a href="UserFeedback">Feedback</a></li>
        <li><a href="UserInb">Inbox</a></li>
    </ul>
</div>