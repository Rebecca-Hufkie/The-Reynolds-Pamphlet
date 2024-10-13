<?php
// src/api.php

require_once '../config/db.php';

function sendResponse($data, $status = 200) {
    header('Content-Type: application/json');
    http_response_code($status);
    echo json_encode($data);
    exit();
}

function handleError($message, $status = 400) {
    sendResponse(['error' => $message], $status);
}


function handleGetRequest() {
    $conn = getDBConnection();
    $result = $conn->query("SELECT * FROM users"); // Example query

    if ($result->num_rows > 0) {
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        sendResponse($data);
    } else {
        sendResponse(['message' => 'No records found.'], 404);
    }
}

function handlePostRequest() {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($input['name']) || !isset($input['email'])) {
        sendResponse(['message' => 'Invalid input'], 400);
    }

    $conn = getDBConnection();
    $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
    $stmt->bind_param('ss', $input['name'], $input['email']);
    
    if ($stmt->execute()) {
        sendResponse(['message' => 'User created successfully.'], 201);
    } else {
        sendResponse(['message' => 'Error creating user.'], 500);
    }
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        handleGetRequest();
        break;
    case 'POST':
        handlePostRequest();
        break;
    default:
        sendResponse(['message' => 'Method not allowed.'], 405);
        break;
}
