SELECT * FROM Products where name like CONCAT('%', :name, '%')
ORDER BY $orderby $sort_order