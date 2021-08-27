# Informix

Informix是IBM公司出品的关系数据库管理系统（RDBMS）家族。   


集成 Cisco Cucm 产品时，需要调用 Axl API：`executeSqlQuery`，了解到 CUCM 使用的是 IBM 的 Informix 数据库。   


Informix 数据库不支持 `LIMIT 0,10` 语句，需要使用 `skip 0 limit 10`。 
