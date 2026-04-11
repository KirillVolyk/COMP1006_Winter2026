CREATE TABLE tasks (
  task_id INT AUTO_INCREMENT PRIMARY KEY,
  task_name  VARCHAR(255),
  task_priority ENUM('Low', 'Medium', 'High'),
  task_time_estimate TINYINT,
  task_deadline DATETIME,
  task_status ENUM('Not Started', 'In Progress', 'Completed'),
  tasked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
