--
-- PostgreSQL database dump
--

\restrict YnwOuwOyXT4fNQCie93udbGVaWQrf0JAYFbJ7Zu9OeLh2C88zRyqfWceqlbbFlS

-- Dumped from database version 16.15 (Ubuntu 16.15-0ubuntu0.24.04.1)
-- Dumped by pg_dump version 16.15 (Ubuntu 16.15-0ubuntu0.24.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: cache; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache OWNER TO postgres;

--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO postgres;

--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


ALTER TABLE public.job_batches OWNER TO postgres;

--
-- Name: jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.jobs OWNER TO postgres;

--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jobs_id_seq OWNER TO postgres;

--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: oauth_access_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.oauth_access_tokens (
    id character(80) NOT NULL,
    user_id bigint,
    client_id uuid NOT NULL,
    name character varying(255),
    scopes text,
    revoked boolean NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone
);


ALTER TABLE public.oauth_access_tokens OWNER TO postgres;

--
-- Name: oauth_auth_codes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.oauth_auth_codes (
    id character(80) NOT NULL,
    user_id bigint NOT NULL,
    client_id uuid NOT NULL,
    scopes text,
    revoked boolean NOT NULL,
    expires_at timestamp(0) without time zone
);


ALTER TABLE public.oauth_auth_codes OWNER TO postgres;

--
-- Name: oauth_clients; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.oauth_clients (
    id uuid NOT NULL,
    owner_type character varying(255),
    owner_id bigint,
    name character varying(255) NOT NULL,
    secret character varying(255),
    provider character varying(255),
    redirect_uris text NOT NULL,
    grant_types text NOT NULL,
    revoked boolean NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.oauth_clients OWNER TO postgres;

--
-- Name: oauth_device_codes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.oauth_device_codes (
    id character(80) NOT NULL,
    user_id bigint,
    client_id uuid NOT NULL,
    user_code character(8) NOT NULL,
    scopes text NOT NULL,
    revoked boolean NOT NULL,
    user_approved_at timestamp(0) without time zone,
    last_polled_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone
);


ALTER TABLE public.oauth_device_codes OWNER TO postgres;

--
-- Name: oauth_refresh_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.oauth_refresh_tokens (
    id character(80) NOT NULL,
    access_token_id character(80) NOT NULL,
    revoked boolean NOT NULL,
    expires_at timestamp(0) without time zone
);


ALTER TABLE public.oauth_refresh_tokens OWNER TO postgres;

--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO postgres;

--
-- Name: permission_role; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.permission_role (
    id bigint NOT NULL,
    role_id bigint NOT NULL,
    permission_id bigint NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.permission_role OWNER TO postgres;

--
-- Name: permission_role_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.permission_role_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.permission_role_id_seq OWNER TO postgres;

--
-- Name: permission_role_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.permission_role_id_seq OWNED BY public.permission_role.id;


--
-- Name: permission_user; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.permission_user (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    permission_id bigint NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.permission_user OWNER TO postgres;

--
-- Name: permission_user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.permission_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.permission_user_id_seq OWNER TO postgres;

--
-- Name: permission_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.permission_user_id_seq OWNED BY public.permission_user.id;


--
-- Name: permissions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.permissions (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.permissions OWNER TO postgres;

--
-- Name: permissions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.permissions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.permissions_id_seq OWNER TO postgres;

--
-- Name: permissions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.permissions_id_seq OWNED BY public.permissions.id;


--
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name text NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.personal_access_tokens OWNER TO postgres;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.personal_access_tokens_id_seq OWNER TO postgres;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- Name: roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.roles (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    is_default boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.roles OWNER TO postgres;

--
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.roles_id_seq OWNER TO postgres;

--
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO postgres;

--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    phone character varying(255),
    role_id bigint NOT NULL,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: permission_role id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permission_role ALTER COLUMN id SET DEFAULT nextval('public.permission_role_id_seq'::regclass);


--
-- Name: permission_user id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permission_user ALTER COLUMN id SET DEFAULT nextval('public.permission_user_id_seq'::regclass);


--
-- Name: permissions id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permissions ALTER COLUMN id SET DEFAULT nextval('public.permissions_id_seq'::regclass);


--
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- Name: roles id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache (key, value, expiration) FROM stdin;
\.


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_roles_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	0001_01_01_000003_create_users_table	1
5	2026_04_01_103851_create_personal_access_tokens_table	1
6	2026_04_01_110656_create_oauth_auth_codes_table	1
7	2026_04_01_110657_create_oauth_access_tokens_table	1
8	2026_04_01_110658_create_oauth_refresh_tokens_table	1
9	2026_04_01_110659_create_oauth_clients_table	1
10	2026_04_01_110700_create_oauth_device_codes_table	1
11	2026_05_19_100601_create_permissions_table	1
12	2026_05_19_133503_create_permission_user_table	1
13	2026_05_19_133518_create_permission_role_table	1
\.


--
-- Data for Name: oauth_access_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.oauth_access_tokens (id, user_id, client_id, name, scopes, revoked, created_at, updated_at, expires_at) FROM stdin;
eb9a717e5d193683488fea450a54cf751d339553e8705fc1a0f8c3fab5eb73dca1c478ae82fed02c	1	01a05ca2-2b1d-715e-a50f-066e33421f44	\N	[]	f	2026-09-01 12:06:46	2026-09-01 12:06:46	2026-09-16 12:06:46
c752de8c60ded5e945d5557682f03145ef315bdf9198bcf550709dc592eebc7f4f48e8e1d4a6a42e	1	01a05ca2-2b1d-715e-a50f-066e33421f44	\N	[]	f	2026-09-03 12:05:41	2026-09-03 12:05:41	2026-09-18 12:05:40
4b2fe760be3feaf3306dfcdad0860b4a6d7d18239bc6730ccaf6b788cd8d2f2e53b78987b7b5d092	1	01a05ca2-2b1d-715e-a50f-066e33421f44	\N	[]	f	2026-09-03 12:09:43	2026-09-03 12:09:43	2026-09-18 12:09:43
d2aab747a721208a9375db29b45c4be09d9f61bdbb51b91b9c6328e5d410b5b5daec79774936583c	1	01a05ca2-2b1d-715e-a50f-066e33421f44	\N	[]	f	2026-09-03 12:22:31	2026-09-03 12:22:31	2026-09-18 12:22:31
6d6d1d7427353d6a461a5aa17891002a062d23c7521a9e285d5a75114555e5f02572e8d9be20c09e	1	01a05ca2-2b1d-715e-a50f-066e33421f44	\N	[]	f	2026-09-03 13:15:55	2026-09-03 13:15:55	2026-09-18 13:15:55
c4491eaf1de2ed9a00b2fed86e9c5f46339d851301108afcf74e31ae4130cc36e3bc781d602ab358	1	01a05ca2-2b1d-715e-a50f-066e33421f44	\N	[]	f	2026-09-03 13:44:34	2026-09-03 13:44:34	2026-09-18 13:44:34
f00c9c40749cf533d8d3c5debfc7aa9e35e905b7d1e0f532a78680dc0a9428bad137d759e652611b	1	01a05ca2-2b1d-715e-a50f-066e33421f44	\N	[]	f	2026-09-03 15:02:21	2026-09-03 15:02:21	2026-09-18 15:02:21
debd62a0fadf35e0b2177a123aa013f4b2968b11799612cae31b54b6b6466834c6fa5031f104628d	1	01a05ca2-2b1d-715e-a50f-066e33421f44	\N	[]	f	2026-09-04 08:32:46	2026-09-04 08:32:46	2026-09-19 08:32:46
2894efc20c038f09a52d1c5b6054013222a2ff8ffafe6531942ee6debfdc1e13ee2cf2a34f8f86c5	1	01a05ca2-2b1d-715e-a50f-066e33421f44	\N	["*"]	f	2026-09-04 08:36:40	2026-09-04 08:36:40	2026-09-19 08:36:40
7227156ee8f8881a1b41d8908678d79771f4fbb38f62fe05b9322dbf90639fc888131dd37ec60358	1	01a05ca2-2b1d-715e-a50f-066e33421f44	\N	["*"]	f	2026-09-04 08:39:54	2026-09-04 08:39:54	2026-09-19 08:39:54
7278c3cbc57ca0d1e58a280a69741a459cab5f8088628d4812de380ad01c5dbfb5136d538d834b3f	1	01a05ca2-2b1d-715e-a50f-066e33421f44	\N	["*"]	f	2026-09-04 08:40:33	2026-09-04 08:40:33	2026-09-19 08:40:33
b7ce44e60c3fcf6de2df3e0b15325444cdf550a9555aa4e5329c620df860201b403c0a1704312349	1	01a05ca2-2b1d-715e-a50f-066e33421f44	\N	[]	f	2026-09-04 10:08:11	2026-09-04 10:08:11	2026-09-19 10:08:11
a50d5a8a9d70a30a8fe8b352b85f0fb6bbae3e6beb0dc3b0c5c83a77e087329e4a1b5ad4bef6a055	1	01a05ca2-2b1d-715e-a50f-066e33421f44	\N	[]	f	2026-09-07 07:52:52	2026-09-07 07:52:52	2026-09-22 07:52:52
02347b7cec01093b3fdf2b709a35fe5c8e057acf17b12d07f7f59adfdfc7b171ce111c41f84040af	1	01a05ca2-2b1d-715e-a50f-066e33421f44	\N	[]	f	2026-09-07 09:10:48	2026-09-07 09:10:48	2026-09-22 09:10:48
994e7507c174195890c158955613f402aceb63441348c837e9dcfac61a6c3e4035a80fce1f52d023	1	01a05ca2-2b1d-715e-a50f-066e33421f44	\N	[]	f	2026-09-07 09:22:52	2026-09-07 09:22:52	2026-09-22 09:22:52
0ce24936e287a83f1b743e9960c5dce5534cb071378a2c5e3e8b3f7a451fe91ff2ee75512b693a28	1	01a05ca2-2b1d-715e-a50f-066e33421f44	\N	[]	f	2026-09-07 09:23:28	2026-09-07 09:23:28	2026-09-22 09:23:28
c16ba54bc1aa82065cde164038993624b349095767996d41bb1eb431146c899d20e7319426efa20e	1	01a05ca2-2b1d-715e-a50f-066e33421f44	\N	[]	f	2026-09-07 09:47:08	2026-09-07 09:47:08	2026-09-22 09:47:08
a716c2282b11488a069b06c1d785c8eb04dc21f062d4f966e2c0c5a277da16678d40b8693db29b71	1	01a05ca2-2b1d-715e-a50f-066e33421f44	\N	[]	f	2026-09-08 13:31:46	2026-09-08 13:31:46	2026-09-23 13:31:46
db701a1614ac667ed37d45bbd9563025e05e8595571a98fe34a0eba19035d2e2b88e5d464a8605a1	1	01a05ca2-2b1d-715e-a50f-066e33421f44	\N	[]	f	2026-09-08 13:34:36	2026-09-08 13:34:36	2026-09-23 13:34:36
5b6feea0b4ea11e7bb383c205095b50923128d2b88bb82960b82d62cf234b07ec82ea0d496ee7192	1	01a05ca2-2b1d-715e-a50f-066e33421f44	\N	[]	f	2026-09-09 06:50:12	2026-09-09 06:50:12	2026-09-24 06:50:12
34aaf20987442fd70eb3f24ba1eb82c6a2f97cdf9109b47988fe2189efa3a27c92d8872d6dc1bc13	1	01a05ca2-2b1d-715e-a50f-066e33421f44	\N	[]	f	2026-09-09 07:19:21	2026-09-09 07:19:21	2026-09-24 07:19:21
0f599c8049e2820cfd75f6bed724711087238d0445b3278a80b555b8376aa78970d5b5fdd8644c25	1	01a05ca2-2b1d-715e-a50f-066e33421f44	\N	[]	f	2026-09-09 07:28:14	2026-09-09 07:28:14	2026-09-24 07:28:14
65b19427d69708374a33f896bd1f6ff6a62b042d4446135f3601f73cbb19e9f72596c727cc0708e8	1	01a05ca2-2b1d-715e-a50f-066e33421f44	\N	[]	f	2026-09-09 08:16:21	2026-09-09 08:16:21	2026-09-24 08:16:21
\.


--
-- Data for Name: oauth_auth_codes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.oauth_auth_codes (id, user_id, client_id, scopes, revoked, expires_at) FROM stdin;
\.


--
-- Data for Name: oauth_clients; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.oauth_clients (id, owner_type, owner_id, name, secret, provider, redirect_uris, grant_types, revoked, created_at, updated_at) FROM stdin;
01a056c7-2861-73ab-88d8-060547a5fccc	\N	\N	Laravel	$2y$12$FHJBBuD06LIF5XTMrRiBuuxes0rUgskXRMzJrE3AhX.ycy3Wuh1Y.	users	[]	["password","refresh_token"]	f	2026-08-31 07:44:47	2026-08-31 07:44:47
01a05ca2-2b1d-715e-a50f-066e33421f44	\N	\N	test	$2y$12$qFV6Ve2I2UYKOD867G2/ResT3TOjyEVWjIlFjZcLPJKa38OCXjxEu	users	[]	["password","refresh_token"]	f	2026-09-01 11:02:06	2026-09-01 11:02:06
\.


--
-- Data for Name: oauth_device_codes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.oauth_device_codes (id, user_id, client_id, user_code, scopes, revoked, user_approved_at, last_polled_at, expires_at) FROM stdin;
\.


--
-- Data for Name: oauth_refresh_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.oauth_refresh_tokens (id, access_token_id, revoked, expires_at) FROM stdin;
76b993e82ecf89a83a8c8aac74c253a5c31a6cae92f81f6a64dac9479df81884227c1f5af51e5ec6	eb9a717e5d193683488fea450a54cf751d339553e8705fc1a0f8c3fab5eb73dca1c478ae82fed02c	f	2026-10-01 12:06:46
2b726c99dc4eaf5a6052253f2201928cf1f99f999f21dea2c4b2c6d2a7d70f260cf81f4c70fa5f42	c752de8c60ded5e945d5557682f03145ef315bdf9198bcf550709dc592eebc7f4f48e8e1d4a6a42e	f	2026-10-03 12:05:41
8e7b5222c4aae5641af61567077ef3f0cffd3cc214d3757d21af49b1bbb2720e97d44d48d60ebc80	4b2fe760be3feaf3306dfcdad0860b4a6d7d18239bc6730ccaf6b788cd8d2f2e53b78987b7b5d092	f	2026-10-03 12:09:43
d999ee3f978ab87eb1e6bf55b10281f23442dd4cedcb11e74ce381c898b72b6e1df9bf091fbc6531	d2aab747a721208a9375db29b45c4be09d9f61bdbb51b91b9c6328e5d410b5b5daec79774936583c	f	2026-10-03 12:22:31
20cfe38f078fe28bdec9912bf1d134140148f3875535ecac09bd82a07b4cb99d77031e037ab49f23	6d6d1d7427353d6a461a5aa17891002a062d23c7521a9e285d5a75114555e5f02572e8d9be20c09e	f	2026-10-03 13:15:55
4fefd3d5daeb22188037aaa5a97046113331e6db3900f44e7145b35ffea27749d92be14887813b52	c4491eaf1de2ed9a00b2fed86e9c5f46339d851301108afcf74e31ae4130cc36e3bc781d602ab358	f	2026-10-03 13:44:34
53f587a1ca4c1c40bcc7b5b0197689e7e0b34d0599426afcc917692f016e1f3db9e961ea28e94bba	f00c9c40749cf533d8d3c5debfc7aa9e35e905b7d1e0f532a78680dc0a9428bad137d759e652611b	f	2026-10-03 15:02:21
b788c7ea406b1b7982b34a2db7245b88a23a01149ea10bf6499a245e7001b5c2beb12465db15295c	debd62a0fadf35e0b2177a123aa013f4b2968b11799612cae31b54b6b6466834c6fa5031f104628d	f	2026-10-04 08:32:46
33ee511f13c3b85c469ee27207aecdc3675542ea6479949f72cf5d6dfc48797a640308b5bebab41b	2894efc20c038f09a52d1c5b6054013222a2ff8ffafe6531942ee6debfdc1e13ee2cf2a34f8f86c5	f	2026-10-04 08:36:40
8bee225e111c8219833e9d7204cf4459dcae63b23d65148a1c656c1267c6b9437822ffa131eb0ae4	7227156ee8f8881a1b41d8908678d79771f4fbb38f62fe05b9322dbf90639fc888131dd37ec60358	f	2026-10-04 08:39:54
1a1533b4abbb09416f8699c15ed8f1396d5266801614662a9f0b18c433c914e41c855119312abcb6	7278c3cbc57ca0d1e58a280a69741a459cab5f8088628d4812de380ad01c5dbfb5136d538d834b3f	f	2026-10-04 08:40:33
87074ad267dbfc52bf4800a5a2bb2bd4e702ca34ba92a8e575647a1b44ffa5908ccb64f401064772	b7ce44e60c3fcf6de2df3e0b15325444cdf550a9555aa4e5329c620df860201b403c0a1704312349	f	2026-10-04 10:08:11
3f8fecb074a11c4651537fbbd7a6076b9302510bb39baa44893240b81aadfba61f08b0ba395aae45	a50d5a8a9d70a30a8fe8b352b85f0fb6bbae3e6beb0dc3b0c5c83a77e087329e4a1b5ad4bef6a055	f	2026-10-07 07:52:53
fe5de69900c508ebb3b49e056a20a4f5ca915f608a9561c49839a55fcd697f36f6325e8f57265ac4	02347b7cec01093b3fdf2b709a35fe5c8e057acf17b12d07f7f59adfdfc7b171ce111c41f84040af	f	2026-10-07 09:10:48
5e7dd8791c8feb6201a765162bcf04c6e32cae58ef6d1b70c419ffc6ddd04707ae90bd6f2ae240f6	994e7507c174195890c158955613f402aceb63441348c837e9dcfac61a6c3e4035a80fce1f52d023	f	2026-10-07 09:22:52
a07ea72b902ce1e9bd9d5f8749c02affbe11a982837523171f6a6c44f62171b73392c263fa45d7c4	0ce24936e287a83f1b743e9960c5dce5534cb071378a2c5e3e8b3f7a451fe91ff2ee75512b693a28	f	2026-10-07 09:23:28
cfe7af20bfda4e9c60badbb29db982bb4e84e3a353e6c2bc21d90a527641e785adc7a47e241dc24b	c16ba54bc1aa82065cde164038993624b349095767996d41bb1eb431146c899d20e7319426efa20e	f	2026-10-07 09:47:08
347d3134b46a05b6ed5062a7d49e6e666ff6dae2b2680dfb37e0b89df94e25481f1a376f74ce6523	a716c2282b11488a069b06c1d785c8eb04dc21f062d4f966e2c0c5a277da16678d40b8693db29b71	f	2026-10-08 13:31:46
91deb2660201eb6b95a11cc93cf3b19c3e47fe5b8d43a348760e6c68182e2d046770405d4b4df5fb	db701a1614ac667ed37d45bbd9563025e05e8595571a98fe34a0eba19035d2e2b88e5d464a8605a1	f	2026-10-08 13:34:36
b0a495aa5ee83d8c38838c6d7f0fd8f6bb62b1ed7bad4dfb1dcdd859988ad157c5ded4d4a4a91576	5b6feea0b4ea11e7bb383c205095b50923128d2b88bb82960b82d62cf234b07ec82ea0d496ee7192	f	2026-10-09 06:50:12
5f6397fb20aa1bf5cf585975ee49d111c5f07e7e785bcee658e6db571b10181d5956dd7905ade99d	34aaf20987442fd70eb3f24ba1eb82c6a2f97cdf9109b47988fe2189efa3a27c92d8872d6dc1bc13	f	2026-10-09 07:19:21
84f7fbfe418bfc6f094b5eff8161308edb2da260d41ea7bb1b4cdb3e97e7f2a51727753e49a390cc	0f599c8049e2820cfd75f6bed724711087238d0445b3278a80b555b8376aa78970d5b5fdd8644c25	f	2026-10-09 07:28:14
1db9fb8d03ff1b8fc3c188cf2d4bb3d84dde1cb342f20921d8bf03d4c62ed454230d232b050099a6	65b19427d69708374a33f896bd1f6ff6a62b042d4446135f3601f73cbb19e9f72596c727cc0708e8	f	2026-10-09 08:16:21
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: permission_role; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.permission_role (id, role_id, permission_id, created_at) FROM stdin;
1	1	1	\N
2	1	2	\N
3	1	3	\N
4	1	4	\N
5	1	5	\N
6	1	6	\N
7	1	7	\N
8	1	8	\N
9	1	9	\N
10	1	10	\N
11	1	11	\N
12	1	12	\N
13	1	13	\N
14	1	14	\N
15	2	2	\N
16	2	3	\N
17	2	4	\N
18	2	14	\N
\.


--
-- Data for Name: permission_user; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.permission_user (id, user_id, permission_id, created_at) FROM stdin;
1	1	1	\N
2	1	2	\N
3	1	3	\N
4	1	4	\N
5	1	5	\N
6	1	6	\N
7	1	7	\N
8	1	8	\N
9	1	9	\N
10	1	10	\N
11	1	11	\N
12	1	12	\N
13	1	13	\N
14	1	14	\N
15	2	2	\N
16	2	3	\N
17	2	4	\N
18	2	14	\N
\.


--
-- Data for Name: permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.permissions (id, name, created_at, updated_at) FROM stdin;
1	read other user	\N	\N
2	update other user	\N	\N
3	delete other user	\N	\N
4	create role	\N	\N
5	read other role	\N	\N
6	update role	\N	\N
7	delete role	\N	\N
8	create permission_user	\N	\N
9	read other permission_user	\N	\N
10	delete permission_user	\N	\N
11	create permission_role	\N	\N
12	read other permission_role	\N	\N
13	delete permission_role	\N	\N
14	read permission	\N	\N
\.


--
-- Data for Name: personal_access_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, expires_at, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.roles (id, name, is_default, created_at, updated_at) FROM stdin;
1	admin	f	\N	\N
2	org	f	\N	\N
3	volunteer	f	\N	\N
4	visitor	t	\N	\N
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
0jP0TK77OBD7tx9hAPSxVbP01rL0Gv50QMKCnukz	\N	127.0.0.1	curl/8.5.0	YToyOntzOjY6Il90b2tlbiI7czo0MDoiZVNFdkhIT0hzcHlqUGs5WVJZd0F2N2llcWdCQ0Zyb25oYXdZb25aTiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1788174364
uVEsUhEiZsp8ucGcd9ZHQ0IQm8pN1UH411Gi9H8H	\N	127.0.0.1	curl/8.19.0	YToyOntzOjY6Il90b2tlbiI7czo0MDoieExHN2NrbGRMbDlKSzB5T2hhbDFCR2hTeWlMTWpKT0c1bWJVa3BraCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1788175208
MoKxlLNm8AvZwx8vrChOJIbegSBAYOl6EkBWlKuc	\N	127.0.0.1	curl/8.19.0	YToyOntzOjY6Il90b2tlbiI7czo0MDoiRnZIRll0eVkzSlJsQnduaGhFYkVKSDhNekJGTE1uNDdkQWs5amdTeSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1788175249
kXeednJ2Yj3MvGahSrmPP2l8y2bJprFDYnFNWnfS	\N	\N		YTozOntzOjY6Il90b2tlbiI7czo0MDoiQVZ1THRDUFhnWVMwR2w3eEFMTzg2azJaMTBtdGx0QUg0WW5EY0hxTyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODoiaHR0cDovLzoiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=	1788264965
v5Ou75KG8uvyFztWqtN0cAQrT7zGxQQ7VfIfDVzi	\N	127.0.0.1	curl/8.5.0	YTozOntzOjY6Il90b2tlbiI7czo0MDoidEFlNW5MelJiOGdxSzFwRTJEeFJ3MDJGTVJTRmF1ang2TUhsTk9hcCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMSI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1788440675
FseCZjg9lwNdWagQjdmen8Q9zcg2gtOJgkcWqBFV	\N	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36	YTozOntzOjY6Il90b2tlbiI7czo0MDoiNlY2Z2tMUElTVEpkS3JqV1V5WkxYR0paQk45QVB4UE5YWG41U0lJTyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODA4MCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1793086558
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, email, email_verified_at, phone, role_id, password, remember_token, created_at, updated_at) FROM stdin;
1	Admin User	admin@example.com	2026-08-28 13:32:09	\N	1	$2y$12$sZZV71xU605/kW7g/Sm.5OLwgrJZbEt1XCIFzBwZ4IniUGnOtbc46	\N	2026-08-28 13:32:09	2026-08-28 13:32:09
2	Org User	org@example.com	2026-08-28 13:32:09	\N	2	$2y$12$pjEW55bJnSdH8S7HFj12weW8otbNpT.9uFXpGoIKb6ITZ7trh3m6S	\N	2026-08-28 13:32:10	2026-08-28 13:32:10
3	Volunteer User	volunteer@example.com	2026-08-28 13:32:10	\N	3	$2y$12$hNNYGI5WL8625COSndXZKeEfmTFIEdjAR5xbt/2DM5TYD/cgBwl32	\N	2026-08-28 13:32:10	2026-08-28 13:32:10
4	Visitor User	visitor@example.com	2026-08-28 13:32:10	\N	4	$2y$12$NW.lyNbS3oG0KOuS8rXdTuelibjmc/h5PG4ccyCmiaJGgC8952Cbm	\N	2026-08-28 13:32:10	2026-08-28 13:32:10
\.


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 13, true);


--
-- Name: permission_role_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.permission_role_id_seq', 18, true);


--
-- Name: permission_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.permission_user_id_seq', 18, true);


--
-- Name: permissions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.permissions_id_seq', 14, true);


--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 1, false);


--
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.roles_id_seq', 4, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 4, true);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: oauth_access_tokens oauth_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oauth_access_tokens
    ADD CONSTRAINT oauth_access_tokens_pkey PRIMARY KEY (id);


--
-- Name: oauth_auth_codes oauth_auth_codes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oauth_auth_codes
    ADD CONSTRAINT oauth_auth_codes_pkey PRIMARY KEY (id);


--
-- Name: oauth_clients oauth_clients_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oauth_clients
    ADD CONSTRAINT oauth_clients_pkey PRIMARY KEY (id);


--
-- Name: oauth_device_codes oauth_device_codes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oauth_device_codes
    ADD CONSTRAINT oauth_device_codes_pkey PRIMARY KEY (id);


--
-- Name: oauth_device_codes oauth_device_codes_user_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oauth_device_codes
    ADD CONSTRAINT oauth_device_codes_user_code_unique UNIQUE (user_code);


--
-- Name: oauth_refresh_tokens oauth_refresh_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oauth_refresh_tokens
    ADD CONSTRAINT oauth_refresh_tokens_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: permission_role permission_role_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permission_role
    ADD CONSTRAINT permission_role_pkey PRIMARY KEY (id);


--
-- Name: permission_user permission_user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permission_user
    ADD CONSTRAINT permission_user_pkey PRIMARY KEY (id);


--
-- Name: permissions permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_phone_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_phone_unique UNIQUE (phone);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: cache_expiration_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cache_expiration_index ON public.cache USING btree (expiration);


--
-- Name: cache_locks_expiration_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cache_locks_expiration_index ON public.cache_locks USING btree (expiration);


--
-- Name: default_role_unique; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX default_role_unique ON public.roles USING btree (is_default) WHERE (is_default = true);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: oauth_access_tokens_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX oauth_access_tokens_user_id_index ON public.oauth_access_tokens USING btree (user_id);


--
-- Name: oauth_auth_codes_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX oauth_auth_codes_user_id_index ON public.oauth_auth_codes USING btree (user_id);


--
-- Name: oauth_clients_owner_type_owner_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX oauth_clients_owner_type_owner_id_index ON public.oauth_clients USING btree (owner_type, owner_id);


--
-- Name: oauth_device_codes_client_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX oauth_device_codes_client_id_index ON public.oauth_device_codes USING btree (client_id);


--
-- Name: oauth_device_codes_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX oauth_device_codes_user_id_index ON public.oauth_device_codes USING btree (user_id);


--
-- Name: oauth_refresh_tokens_access_token_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX oauth_refresh_tokens_access_token_id_index ON public.oauth_refresh_tokens USING btree (access_token_id);


--
-- Name: personal_access_tokens_expires_at_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX personal_access_tokens_expires_at_index ON public.personal_access_tokens USING btree (expires_at);


--
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: permission_role permission_role_permission_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permission_role
    ADD CONSTRAINT permission_role_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON DELETE CASCADE;


--
-- Name: permission_role permission_role_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permission_role
    ADD CONSTRAINT permission_role_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- Name: permission_user permission_user_permission_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permission_user
    ADD CONSTRAINT permission_user_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON DELETE CASCADE;


--
-- Name: permission_user permission_user_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permission_user
    ADD CONSTRAINT permission_user_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: users users_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE RESTRICT;


--
-- PostgreSQL database dump complete
--

\unrestrict YnwOuwOyXT4fNQCie93udbGVaWQrf0JAYFbJ7Zu9OeLh2C88zRyqfWceqlbbFlS

