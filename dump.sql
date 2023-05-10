
create table cinema(
    cinema_id int not null AUTO_INCREMENT primary key,
    cinema_name varchar(50) not null,
    cinema_address varchar(255) not null
);

create table cinemahall(
    cinemahall_id int not null AUTO_INCREMENT primary key,
    cinemahall_schema json not null,
    cinemahall_size int not null,
    cinema_id int not null,
    foreign key (cinema_id) references cinema(cinema_id)
);

create table genre(
    genre_id int not null AUTO_INCREMENT primary key,
    genre_name varchar(50) not null
);

create table movie(
    movie_id int not null AUTO_INCREMENT primary key,
    movie_name varchar(50) not null,
    movie_price float not null,
    movie_description mediumtext not null,
    movie_producer varchar(50) not null,
    movie_year date not null,
    movie_duration int not null
);

create table movie_asset(
    movie_asset_id int not null AUTO_INCREMENT primary key,
    movie_id int not null,
    movie_asset_url varchar(255) not null,
    movie_asset_type varchar(20) not null
);

create table movie_genre(
    movie_genre_id int not null AUTO_INCREMENT primary key,
    movie_id int not null,
    genre_id int not null,
    foreign key (genre_id) references genre(genre_id),
    foreign key (movie_id) references movie(movie_id)
);

create table session(
    session_id int not null AUTO_INCREMENT primary key,
    movie_id int not null,
    cinemahall_id int not null,
    session_time datetime not null,
    session_schema json not null,
    foreign key (cinemahall_id) references cinemahall(cinemahall_id),
    foreign key (movie_id) references movie(movie_id)
);

create table ticket(
    ticket_id int not null AUTO_INCREMENT primary key,
    ticket_row int not null,
    ticket_place int not null,
    session_id int not null,
    foreign key (session_id) references session(session_id)
);


insert into cinema(cinema_name, cinema_address) values ('Cineplex Loteanu', 'Bulevardul Ștefan cel Mare și Sfînt 103');
insert into cinema(cinema_name, cinema_address) values ('Cineplex', 'Arborilor, 21');


insert into cinemahall(cinemahall_schema, cinemahall_size, cinema_id)
    values('[
        [true, true, true, true, true, true, true, true],
        [true, true, true, true, true, true, true, true],
        [true, true, true, true, true, true, true, true],
        [true, true, true, true, true, true, true, true],
        [true, true, true, true, true, true, true, true],
        [true, true, true, true, true, true, true, true],
        [true, true, true, true, true, true, true, true],
        [true, true, true, true, true, true, true, true],
        [true, true, true, true, true, true, true, true, true, true, true, true, true, true, true]
    ]', '79', (select cinema_id from cinema where cinema_name='Cineplex Loteanu'));
insert into cinemahall(cinemahall_schema, cinemahall_size, cinema_id)
    values('[
        [true, true, true, true, true, true, true, true, true, true, true, true],
        [true, true, true, true, true, true, true, true, true, true, true, true],
        [true, true, true, true, true, true, true, true],
        [true, true, true, true, true, true, true, true],
        [true, true, true, true, true, true, true, true],
        [true, true, true, true, true, true, true, true],
        [true, true, true, true, true, true, true, true, true, true, true, true, true, true, true],
        [true, true, true, true, true, true, true, true, true, true, true, true, true, true, true]
     ]', '86', (select cinema_id from cinema where cinema_name='Cineplex Loteanu'));
insert into cinemahall(cinemahall_schema, cinemahall_size, cinema_id)
    values('[
        [true, true, true, true, true, true, true, true, true, true, true, true],
        [true, true, true, true, true, true, true, true],
        [true, true, true, true, true, true, true, true],
        [true, true, true, true, true, true, true, true],
        [true, true, true, true, true, true, true, true, true, true, true, true],
        [true, true, true, true, true, true, true, true, true, true, true, true, true, true, true]
    ]', '63', (select cinema_id from cinema where cinema_name='Cineplex Loteanu'));

insert into cinemahall(cinemahall_schema, cinemahall_size, cinema_id)
    values('[8, 8, 8, 8, 8, 8, 8, 8, 15]', '79', (select cinema_id from cinema where cinema_name='Cineplex'));
insert into cinemahall(cinemahall_schema, cinemahall_size, cinema_id) values('[12, 12, 8, 8, 8, 8, 15, 15]', '86', (select cinema_id from cinema where cinema_name='Cineplex'));

insert into genre(genre_name) values
    ('Action'), ('Drama'), ('Adventure'), ('Comedy'), ('Fantasy'), ('Horror'),
    ('Musical'), ('Mystery'), ('Romance'), ('Cartoon'), ('Documental'), ('Sci-Fi'), ('Crime'), ('Triller'), ('History');

insert into movie(movie_name, movie_price, movie_description, movie_producer, movie_year, movie_duration) values
    ('Guardians of the Galaxy vol.3', 130, "Still reeling from the loss of Gamora, Peter Quill rallies his team to defend the universe and one of their own - a mission that could mean the end of the Guardians if not successful.", "James Gunn", '2023-05-05', '140'),
    ('The Super Mario Bros. Movie', 110, "The story of The Super Mario Bros. on their journey through the Mushroom Kingdom.", 'Aaron Horvath, Michael Jelenic', '2023-04-05', '90'),
    ('Evil Dead Rise', 120, "A twisted tale of two estranged sisters whose reunion is cut short by the rise of flesh-possessing demons, thrusting them into a primal battle for survival as they face the most nightmarish version of family imaginable.", "Lee Cronin", "2023-03-15", '100'),
    ('Les trois mousquetaires: D`Artagnan', 120, "D'Artagnan arrives in Paris trying to find his attackers after being left for dead, which leads him to a real war where the future of France is at stake. He aligns himself with Athos, Porthos and Aramis, three musketeers of the King.", 'Martin Bourboulon', '2023-04-05', '120'),
    ('John Wick: Chapter 4', 110, 'John Wick uncovers a path to defeating The High Table. But before he can earn his freedom, Wick must face off against a new enemy with powerful alliances across the globe and forces that turn old friends into foes.', 'Chad Stahelski', '2023-05-13', '170');

insert into movie_genre(movie_id, genre_id) values
    ((select movie_id from movie where movie_name='Guardians of the Galaxy vol.3'), (select genre_id from genre where genre_name='Action')),
    ((select movie_id from movie where movie_name='Guardians of the Galaxy vol.3'), (select genre_id from genre where genre_name='Adventure')),
    ((select movie_id from movie where movie_name='Guardians of the Galaxy vol.3'), (select genre_id from genre where genre_name='Sci-Fi')),
    ((select movie_id from movie where movie_name='Guardians of the Galaxy vol.3'), (select genre_id from genre where genre_name='Comedy')),
    ((select movie_id from movie where movie_name='The Super Mario Bros. Movie'), (select genre_id from genre where genre_name='Cartoon')),
    ((select movie_id from movie where movie_name='The Super Mario Bros. Movie'), (select genre_id from genre where genre_name='Adventure')),
    ((select movie_id from movie where movie_name='The Super Mario Bros. Movie'), (select genre_id from genre where genre_name='Comedy')),
    ((select movie_id from movie where movie_name='Evil Dead Rise'), (select genre_id from genre where genre_name='Horror')),
    ((select movie_id from movie where movie_name='Les trois mousquetaires: D`Artagnan'), (select genre_id from genre where genre_name='Action')),
    ((select movie_id from movie where movie_name='Les trois mousquetaires: D`Artagnan'), (select genre_id from genre where genre_name='Adventure')),
    ((select movie_id from movie where movie_name='Les trois mousquetaires: D`Artagnan'), (select genre_id from genre where genre_name='History')),
    ((select movie_id from movie where movie_name='John Wick: Chapter 4'), (select genre_id from genre where genre_name='Action')),
    ((select movie_id from movie where movie_name='John Wick: Chapter 4'), (select genre_id from genre where genre_name='Crime')),
    ((select movie_id from movie where movie_name='John Wick: Chapter 4'), (select genre_id from genre where genre_name='Triller'));

insert into session(movie_id, cinemahall_id, session_time, session_schema) values
    ((select movie_id from movie where movie_name='Guardians of the Galaxy vol.3'), (select cinemahall_id from cinemahall limit 1), '2023-07-06 12:00:00', (select cinemahall_schema from cinemahall where cinemahall_id='1')),
    ((select movie_id from movie where movie_name='Guardians of the Galaxy vol.3'), (select cinemahall_id from cinemahall limit 1), '2023-07-06 15:00:00', (select cinemahall_schema from cinemahall where cinemahall_id='2')),
    ((select movie_id from movie where movie_name='Guardians of the Galaxy vol.3'), (select cinemahall_id from cinemahall limit 1), '2023-07-06 18:00:00', (select cinemahall_schema from cinemahall where cinemahall_id='3')),
    ((select movie_id from movie where movie_name='Guardians of the Galaxy vol.3'), (select cinemahall_id from cinemahall limit 1), '2023-07-06 21:00:00', (select cinemahall_schema from cinemahall where cinemahall_id='1')),
    ((select movie_id from movie where movie_name='The Super Mario Bros. Movie'), (select cinemahall_id from cinemahall limit 1), '2023-07-07 12:00:00', (select cinemahall_schema from cinemahall where cinemahall_id='2')),
    ((select movie_id from movie where movie_name='The Super Mario Bros. Movie'), (select cinemahall_id from cinemahall limit 1), '2023-07-07 15:00:00', (select cinemahall_schema from cinemahall where cinemahall_id='3')),
    ((select movie_id from movie where movie_name='The Super Mario Bros. Movie'), (select cinemahall_id from cinemahall limit 1), '2023-07-07 18:00:00', (select cinemahall_schema from cinemahall where cinemahall_id='1')),
    ((select movie_id from movie where movie_name='The Super Mario Bros. Movie'), (select cinemahall_id from cinemahall limit 1), '2023-07-07 21:00:00', (select cinemahall_schema from cinemahall where cinemahall_id='2')),
    ((select movie_id from movie where movie_name='Evil Dead Rise'), (select cinemahall_id from cinemahall limit 1), '2023-07-08 12:00:00', (select cinemahall_schema from cinemahall where cinemahall_id='3')),
    ((select movie_id from movie where movie_name='Evil Dead Rise'), (select cinemahall_id from cinemahall limit 1), '2023-07-08 15:00:00', (select cinemahall_schema from cinemahall where cinemahall_id='1')),
    ((select movie_id from movie where movie_name='Evil Dead Rise'), (select cinemahall_id from cinemahall limit 1), '2023-07-08 18:00:00', (select cinemahall_schema from cinemahall where cinemahall_id='2')),
    ((select movie_id from movie where movie_name='Evil Dead Rise'), (select cinemahall_id from cinemahall limit 1), '2023-07-08 21:00:00', (select cinemahall_schema from cinemahall where cinemahall_id='3'));




insert into movie_asset (movie_id, movie_asset_url, movie_asset_type) values
    ((select movie_id from movie where movie_name='Guardians of the Galaxy vol.3'), 'media/1/FozSgaCaEAIHR6z.jpg', 'poster'),
    ((select movie_id from movie where movie_name='The Super Mario Bros. Movie'), 'media/2/The-Super-Mario-Bros.-Movie-poster.jpg', 'poster'),
    ((select movie_id from movie where movie_name='Evil Dead Rise'), 'media/3/edr.jpg', 'poster'),
    ((select movie_id from movie where movie_name='Les trois mousquetaires: D`Artagnan'), 'media/4/4417568.jpg', 'poster'),
    ((select movie_id from movie where movie_name='John Wick: Chapter 4'), 'media/5/asdasd.jpg', 'poster');

insert into movie_asset (movie_id, movie_asset_url, movie_asset_type) values
    ((select movie_id from movie where movie_name='Guardians of the Galaxy vol.3'), 'u3V5KDHRQvk', 'youtube_trailer'),
    ((select movie_id from movie where movie_name='The Super Mario Bros. Movie'), 'TnGl01FkMMo', 'youtube_trailer'),
    ((select movie_id from movie where movie_name='Evil Dead Rise'), 'BqQNO7BzN08', 'youtube_trailer'),
    ((select movie_id from movie where movie_name='Les trois mousquetaires: D`Artagnan'), 'KqCiVRbwMvQ', 'youtube_trailer'),
    ((select movie_id from movie where movie_name='John Wick: Chapter 4'), 'yjRHZEUamCc', 'youtube_trailer')


