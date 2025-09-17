CREATE TABLE
    `laravel2`.`students` (
        `id` INT (10) NULL AUTO_INCREMENT COMMENT 'id',
        `name` VARCHAR(20) NULL COMMENT '姓名',
        PRIMARY KEY (`id`)
    ) ENGINE = InnoDB CHARSET = utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CREATE
INSERT INTO
    `students` (`id`, `name`)
VALUES
    (NULL, 'Amy');

INSERT INTO
    `students` (`id`, `name`)
VALUES
    (NULL, 'Amy'),
    (NULL, 'Bob'),
    (NULL, 'Cathy'),
    (NULL, 'David'),
    (NULL, 'Emily');

-- READ
SELECT
    *
FROM
    `students`
ORDER BY
    `id` ASC
    -- UPDATE
UPDATE `students`
SET
    `name` = 'Amy123'
WHERE
    `students`.`id` = 1
    -- DELETE
DELETE FROM students
WHERE
    `students`.`id` = 1
