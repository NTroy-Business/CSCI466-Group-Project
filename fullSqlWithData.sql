DROP TABLE IF EXISTS REQUESTS;
DROP TABLE IF EXISTS ORDERS;
DROP TABLE IF EXISTS SHOPPINGCART;
DROP TABLE IF EXISTS STUFFEDANIMALSTORE;

CREATE TABLE STUFFEDANIMALSTORE (
    StuffieID VARCHAR(64) NOT NULL,
    ProductName VARCHAR(64) NOT NULL,
    ProductSize ENUM('S','M','L','XL') NOT NULL,
    Price DECIMAL(6,2) NOT NULL,
    InvQty INT NOT NULL,
    PRIMARY KEY (StuffieID)
);

CREATE TABLE SHOPPINGCART (
    TrackingID VARCHAR(128) NOT NULL,
    StuffieID VARCHAR(64) NOT NULL,
    CartQty INT NOT NULL,
    PRIMARY KEY (TrackingID, StuffieID),
    FOREIGN KEY (StuffieID) REFERENCES STUFFEDANIMALSTORE(StuffieID) ON DELETE CASCADE
);

CREATE TABLE ORDERS (
    TrackingID VARCHAR(128) NOT NULL,
    OrderStatus VARCHAR(32) NOT NULL,
    Total DECIMAL(10,2) NOT NULL,
    CCInfo VARCHAR(20) NOT NULL,
    ShippingAddr VARCHAR(128) NOT NULL,
    BillingAddr VARCHAR(128) NOT NULL,
    PRIMARY KEY (TrackingID),
    FOREIGN KEY (TrackingID) REFERENCES SHOPPINGCART(TrackingID) ON DELETE CASCADE
);

CREATE TABLE REQUESTS (
    TrackingID VARCHAR(128) NOT NULL,
    StuffieID VARCHAR(64) NOT NULL,
    OrderQty INT NOT NULL,
    PRIMARY KEY (TrackingID, StuffieID),
    FOREIGN KEY (TrackingID) REFERENCES ORDERS(TrackingID) ON DELETE CASCADE,
    FOREIGN KEY (StuffieID) REFERENCES STUFFEDANIMALSTORE(StuffieID) ON DELETE CASCADE
);

-- STUFFED ANIMAL STORE
INSERT INTO STUFFEDANIMALSTORE
	(StuffieID, ProductName, ProductSize, Price, InvQty) 
VALUES
	('S001','erawr','M',500.00,3),
	('S002','urawr','M',67.00,6),
	('S003','mirawr','S',3.25,140),
	('S004','tirawr','M',487.75,5),
	('S005','quagsire','L',620.00,2),
	('S006','clodsire','L',980.00,1),
	('S007','tamago','S',495.00,6),
	('S008','shibata','M',420.00,8),
	('S009','shibata BIG','XL',515.00,1),
	('S010','burnt chibatta','M',499.00,2),
	('S011','shibata roll','M',455.00,7),
	('S012','sharkie','L',510.00,2),
	('S013','hedhog','S',520.00,4),
	('S014','coronavirus','XL',2019.00,1),
	('S015','skunkie','M',510.50,3),
	('S016','froggo','S',149.99,11),
	('S017','bearo','L',799.99,2),
	('S018','octoplush','S',8.00,25),
	('S019','snugglecat','S',275.00,5),
	('S020','doggo deluxe','XL',1249.99,1);

-- SHOPPING CART
INSERT INTO SHOPPINGCART
	(TrackingID, StuffieID, CartQty)
VALUES
	('T103','S018',2),
	('T100','S001',1),
	('T104','S010',2),
	('T101','S014',1),
	('T105','S019',1),
	('T100','S003',4),
	('T102','S006',1),
	('T104','S020',1),
	('T101','S002',2),
	('T103','S011',1),
	('T104','S012',1),
	('T102','S007',2),
	('T105','S005',1),
	('T102','S005',1),
	('T103','S009',1);

-- ORDERS
INSERT INTO ORDERS
	(TrackingID, OrderStatus, Total, CCInfo, ShippingAddr, BillingAddr)
VALUES
	('T103','Processing',986.00,'4839-2051-7746-9182','742 First Street, DeKalb, IL','742 First Street, DeKalb, IL'),
	('T100','Processing',513.00,'1928-5501-3349-6671','1289 Sycamore Road, DeKalb, IL','1289 Sycamore Road, DeKalb, IL'),
	('T105','Processing',895.00,'7601-4429-8830-1156','55 Annie Glidden Road, DeKalb, IL','55 Annie Glidden Road, DeKalb, IL'),
	('T102','Shipped',2590.00,'3301-9984-1207-5563','900 Lincoln Highway, DeKalb, IL','900 Lincoln Highway, DeKalb, IL'),
	('T104','Delivered',2258.99,'5810-7743-9921-4408','1200 First Street, DeKalb, IL','1200 First Street, DeKalb, IL'),
	('T101','Processing',2153.00,'9044-2187-6630-5519','311 Sycamore Road, DeKalb, IL','311 Sycamore Road, DeKalb, IL');

-- REQUESTS
INSERT INTO REQUESTS
	(TrackingID, StuffieID, OrderQty)
VALUES
	('T102','S006',1),
	('T100','S001',1),
	('T104','S010',1),
	('T101','S002',2),
	('T103','S018',2),
	('T105','S019',1),
	('T100','S003',4),
	('T104','S020',1),
	('T102','S005',1),
	('T101','S014',1),
	('T103','S011',1),
	('T104','S012',1),
	('T102','S007',2),
	('T105','S005',1),
	('T103','S009',1);
