SELECT  CONCAT(E.first_name,' ',E.last_name) as NomeCompleto,  D.dept_name, DATEDIFF( IFNULL(ED.to_date,CURRENT_DATE()) , from_date) as dias_trabalhados 
FROM employees E
 JOIN dept_emp ED  ON  E.emp_no = ED.emp_no
RIGHT JOIN  departments D ON ED.dept_no = D.dept_no 
order by dias_trabalhados  DESC 
limit 10