SELECT * FROM Products where name like CONCAT('%', :name, '%')