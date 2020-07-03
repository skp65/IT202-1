SELECT * FROM Products where name like CONCAT('%', :name, '%')
ORDER BY name DESC