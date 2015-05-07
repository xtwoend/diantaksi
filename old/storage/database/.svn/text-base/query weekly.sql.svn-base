select count(id),
WEEKOFYEAR(`time_inserted`) AS period
from customers
where `time_inserted` >= CURDATE() - interval 4 week
group by period

