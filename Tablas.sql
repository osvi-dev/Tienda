CREATE TABLE Proveedor (
	ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	Nombre VARCHAR(40),
	Direccion VARCHAR (70),
	Telefono VARCHAR(12)
	
);

CREATE TABLE Almacen (
	ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	Descripcion VARCHAR(100),
	Min INT,
	Max INT,
	Stock INT
);

CREATE TABLE Compra(
	IDProvedor INT,
	IDProducto INT,
	Cant INT,
	Precio INT,
	PRIMARY KEY (IDProvedor, IDProducto) 
);

CREATE TABLE Salida (
	Fecha DATE,
	Hora TIME,
	IDProducto INT,
	Cantidad INT
);



ALTER TABLE Salida ADD CONSTRAINT fk_Produc_Sali FOREIGN KEY (IDProducto) REFERENCES Almacen(ID);
ALTER TABLE Compra ADD CONSTRAINT fk_Prov_Alm FOREIGN KEY (IDProducto) REFERENCES Almacen(ID);
ALTER TABLE Compra ADD CONSTRAINT fk_Prov_Com FOREIGN KEY (IDProvedor) REFERENCES Proveedor(ID);
