provider "aws" {
    region = var.region
    access_key = var.accesskey
    secret_key = var.secretkey
}

resource "aws_vpc" "main" {
  cidr_block = "10.0.0.0/16"
}

resource "aws_internet_gateway" "igw" {
  vpc_id = aws_vpc.main.id
}

resource "aws_subnet" "public" {
  vpc_id     = aws_vpc.main.id
  cidr_block = "10.0.1.0/24"
  availability_zone = "us-west-2a"
  tags = {
    Name = "Public"
  }
}

resource "aws_route_table" "public_route" {
  vpc_id = aws_vpc.main.id

  route {
    cidr_block = "0.0.0.0/0"
    gateway_id = aws_internet_gateway.igw.id
  }
  route {
    ipv6_cidr_block        = "::/0"
    gateway_id = aws_internet_gateway.igw.id
  }
  tags = {
    Name = "Public_Route_Table"
  }
}

resource "aws_route_table_association" "a" {
  subnet_id      = aws_subnet.public.id
  route_table_id = aws_route_table.public_route.id
}


resource "aws_subnet" "private" {
  vpc_id     = aws_vpc.main.id
  cidr_block = "10.0.2.0/24"
  availability_zone = "us-west-2b"
  tags = {
    Name = "Private"
  }
}

resource "aws_security_group" "allow_web-ssh"{
  name="allow_web-ssh"
  vpc_id = aws_vpc.main.id 
  ingress {
    from_port = 3306
    to_port = 3306
    protocol = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  ingress {
    from_port = 443
    to_port = 443
    protocol = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }
  ingress {
    from_port = 80
    to_port = 80
    protocol = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }
  ingress {
    from_port = 22
    to_port = 22
    protocol = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  egress {
    from_port        = 0
    to_port          = 0
    protocol         = "-1"
    cidr_blocks      = ["0.0.0.0/0"]
    ipv6_cidr_blocks = ["::/0"]
  }
}

resource "aws_instance" "web-server" {
    ami = "ami-0d70546e43a941d70"
    instance_type ="t2.large"
    subnet_id = aws_subnet.public.id
    associate_public_ip_address= true
    security_groups= [aws_security_group.allow_web-ssh.id]
    user_data = <<-EOF
                #!/bin/bash
                sudo su
                apt-get update -y
                apt-get upgrade -y
                apt-get install apache2 -y
                apt-get install mysql-server -y
                apt install awscli -y
                apt-get install php libapache2-mod-php php-mysql php-curl php-gd php-json php-zip php-mbstring -y
                cd /
                chmod 777 var/www/html
                cd var/www/html
                git clone https://github.com/varunpanchal283/certific-up.git
                cd certific-up
                wget "https://docs.aws.amazon.com/aws-sdk-php/v3/download/aws.zip"
                apt-get install unzip -y
                unzip aws.zip
                mkdir .aws
                cd .aws
                touch credentials
                echo "[default]" >> credentials
                echo "aws_access_key_id = ${var.accesskey}" >> credentials
                echo "aws_secret_access_key = ${var.secretkey}" >> credentials
                systemctl restart apache2
                EOF
}
resource "aws_db_subnet_group" "dbgroup" {
  name       = "dbgroup"
  subnet_ids = [aws_subnet.public.id, aws_subnet.private.id]
}

variable database_name {
}

variable username {
}

variable password {
}

resource "aws_db_instance" "cdb" {
  allocated_storage    = "10"
  port = "3306"
  vpc_security_group_ids= [aws_security_group.allow_web-ssh.id]
  engine               = "mysql"
  engine_version       = "8.0"
  instance_class       = "db.t2.micro"
  db_name              = var.database_name
  username             = var.username
  password             = var.password
  parameter_group_name = "default.mysql8.0"
  skip_final_snapshot  = true
  db_subnet_group_name = aws_db_subnet_group.dbgroup.name
}
resource "aws_secretsmanager_secret" "mysql" {
  name = "mysql"
}

resource "aws_secretsmanager_secret_version" "v1" {
  secret_id     = aws_secretsmanager_secret.mysql.id
  secret_string = <<EOF
  {
  "username" : "${var.username}",
  "password" : "${var.password}",
  "databasename" : "${var.database_name}",
  "localhost": "${aws_db_instance.cdb.address}"
  }
  EOF
  depends_on = [aws_db_instance.cdb]
}
output "rds_endpoint" {
  value = aws_db_instance.cdb.endpoint
}