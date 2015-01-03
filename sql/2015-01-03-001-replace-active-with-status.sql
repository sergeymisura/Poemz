START TRANSACTION;

ALTER TABLE user ADD status ENUM ('new', 'active', 'disabled') DEFAULT 'new';
UPDATE user SET status = 'active' WHERE id > 0;
ALTER TABLE user DROP COLUMN active;

COMMIT;
