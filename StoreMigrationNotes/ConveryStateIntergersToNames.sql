update 
	accounts
set 
	acc_state = ST.sta_name
from
(
	select 
		sta_id, sta_name 
	from 
		accounts 
	inner join 
		states on acc_state::integer = sta_id
	where 
		acc_state ~ '^[0-9+]'
	group by 
		sta_id
) as ST
where 
	acc_state::integer = ST.sta_id
and 
	acc_state ~ '^[0-9+]'


update 
	accounts
set 
	acc_billstate = ST.sta_name
from
(
	select 
		sta_id, sta_name 
	from 
		accounts 
	inner join 
		states on acc_billstate::integer = sta_id
	where 
		acc_billstate ~ '^[0-9+]'
	group by 
		sta_id
) as ST
where 
	acc_billstate::integer = ST.sta_id
and 
	acc_billstate ~ '^[0-9+]'


ALTER TABLE accounts ALTER COLUMN acc_cou_id TYPE integer USING (acc_cou_id::integer);
ALTER TABLE accounts ALTER COLUMN acc_billcou_id TYPE integer USING (acc_billcou_id::integer);
