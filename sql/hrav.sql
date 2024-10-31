PGDMP  ,    9            	    |            hrav    16.3    16.3     �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    33203    hrav    DATABASE     {   CREATE DATABASE hrav WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Portuguese_Brazil.1252';
    DROP DATABASE hrav;
                postgres    false                        2615    2200    public    SCHEMA     2   -- *not* creating schema, since initdb creates it
 2   -- *not* dropping schema, since initdb creates it
                postgres    false            �           0    0    SCHEMA public    ACL     Q   REVOKE USAGE ON SCHEMA public FROM PUBLIC;
GRANT ALL ON SCHEMA public TO PUBLIC;
                   postgres    false    5            �            1259    33204    tbavaliacao    TABLE       CREATE TABLE public.tbavaliacao (
    avacodigo bigint NOT NULL,
    percodigo bigint NOT NULL,
    setcodigo bigint NOT NULL,
    discodigo bigint NOT NULL,
    avaresposta smallint NOT NULL,
    avafeedback text,
    avadatahora timestamp without time zone DEFAULT now()
);
    DROP TABLE public.tbavaliacao;
       public         heap    postgres    false    5            �            1259    33210    tbdispositivo    TABLE     �   CREATE TABLE public.tbdispositivo (
    discodigo bigint NOT NULL,
    disstatus smallint DEFAULT 0 NOT NULL,
    disnome character varying(200) NOT NULL,
    setcodigo bigint
);
 !   DROP TABLE public.tbdispositivo;
       public         heap    postgres    false    5            �            1259    33214 
   tbpergunta    TABLE     �   CREATE TABLE public.tbpergunta (
    percodigo bigint NOT NULL,
    perpergunta text NOT NULL,
    perativo smallint DEFAULT 0
);
    DROP TABLE public.tbpergunta;
       public         heap    postgres    false    5            �            1259    33220    tbperguntasetor    TABLE     �   CREATE TABLE public.tbperguntasetor (
    percodigo bigint NOT NULL,
    setcodigo bigint NOT NULL,
    pstativo smallint DEFAULT 0 NOT NULL
);
 #   DROP TABLE public.tbperguntasetor;
       public         heap    postgres    false    5            �            1259    33224    tbsetor    TABLE     �   CREATE TABLE public.tbsetor (
    setcodigo bigint NOT NULL,
    setdescricao character varying(200) NOT NULL,
    setativo smallint DEFAULT 0
);
    DROP TABLE public.tbsetor;
       public         heap    postgres    false    5            �            1259    33228 	   tbusuario    TABLE     �   CREATE TABLE public.tbusuario (
    usucodigo bigint NOT NULL,
    usunome character varying(50) NOT NULL,
    ususenha character varying(32) NOT NULL,
    usuativo smallint DEFAULT 0 NOT NULL
);
    DROP TABLE public.tbusuario;
       public         heap    postgres    false    5            �          0    33204    tbavaliacao 
   TABLE DATA           x   COPY public.tbavaliacao (avacodigo, percodigo, setcodigo, discodigo, avaresposta, avafeedback, avadatahora) FROM stdin;
    public          postgres    false    215   �        �          0    33210    tbdispositivo 
   TABLE DATA           Q   COPY public.tbdispositivo (discodigo, disstatus, disnome, setcodigo) FROM stdin;
    public          postgres    false    216   ,       �          0    33214 
   tbpergunta 
   TABLE DATA           F   COPY public.tbpergunta (percodigo, perpergunta, perativo) FROM stdin;
    public          postgres    false    217   },       �          0    33220    tbperguntasetor 
   TABLE DATA           I   COPY public.tbperguntasetor (percodigo, setcodigo, pstativo) FROM stdin;
    public          postgres    false    218   �-       �          0    33224    tbsetor 
   TABLE DATA           D   COPY public.tbsetor (setcodigo, setdescricao, setativo) FROM stdin;
    public          postgres    false    219   �-       �          0    33228 	   tbusuario 
   TABLE DATA           K   COPY public.tbusuario (usucodigo, usunome, ususenha, usuativo) FROM stdin;
    public          postgres    false    220   Q.       4           2606    33233    tbavaliacao pk_tbavaliacao 
   CONSTRAINT     j   ALTER TABLE ONLY public.tbavaliacao
    ADD CONSTRAINT pk_tbavaliacao PRIMARY KEY (avacodigo, percodigo);
 D   ALTER TABLE ONLY public.tbavaliacao DROP CONSTRAINT pk_tbavaliacao;
       public            postgres    false    215    215            6           2606    33235    tbdispositivo pk_tbdispositivo 
   CONSTRAINT     c   ALTER TABLE ONLY public.tbdispositivo
    ADD CONSTRAINT pk_tbdispositivo PRIMARY KEY (discodigo);
 H   ALTER TABLE ONLY public.tbdispositivo DROP CONSTRAINT pk_tbdispositivo;
       public            postgres    false    216            8           2606    33237    tbpergunta pk_tbpergunta 
   CONSTRAINT     ]   ALTER TABLE ONLY public.tbpergunta
    ADD CONSTRAINT pk_tbpergunta PRIMARY KEY (percodigo);
 B   ALTER TABLE ONLY public.tbpergunta DROP CONSTRAINT pk_tbpergunta;
       public            postgres    false    217            :           2606    33239 "   tbperguntasetor pk_tbperguntasetor 
   CONSTRAINT     r   ALTER TABLE ONLY public.tbperguntasetor
    ADD CONSTRAINT pk_tbperguntasetor PRIMARY KEY (percodigo, setcodigo);
 L   ALTER TABLE ONLY public.tbperguntasetor DROP CONSTRAINT pk_tbperguntasetor;
       public            postgres    false    218    218            <           2606    33241    tbsetor pk_tbsetor 
   CONSTRAINT     W   ALTER TABLE ONLY public.tbsetor
    ADD CONSTRAINT pk_tbsetor PRIMARY KEY (setcodigo);
 <   ALTER TABLE ONLY public.tbsetor DROP CONSTRAINT pk_tbsetor;
       public            postgres    false    219            >           2606    33243    tbusuario pk_tbusuario 
   CONSTRAINT     [   ALTER TABLE ONLY public.tbusuario
    ADD CONSTRAINT pk_tbusuario PRIMARY KEY (usucodigo);
 @   ALTER TABLE ONLY public.tbusuario DROP CONSTRAINT pk_tbusuario;
       public            postgres    false    220            ?           2606    33244 &   tbavaliacao fk_tbavaliacao_dispositivo    FK CONSTRAINT     �   ALTER TABLE ONLY public.tbavaliacao
    ADD CONSTRAINT fk_tbavaliacao_dispositivo FOREIGN KEY (discodigo) REFERENCES public.tbdispositivo(discodigo);
 P   ALTER TABLE ONLY public.tbavaliacao DROP CONSTRAINT fk_tbavaliacao_dispositivo;
       public          postgres    false    4662    215    216            @           2606    33249 (   tbavaliacao fk_tbavaliacao_perguntasetor    FK CONSTRAINT     �   ALTER TABLE ONLY public.tbavaliacao
    ADD CONSTRAINT fk_tbavaliacao_perguntasetor FOREIGN KEY (percodigo, setcodigo) REFERENCES public.tbperguntasetor(percodigo, setcodigo) ON UPDATE CASCADE;
 R   ALTER TABLE ONLY public.tbavaliacao DROP CONSTRAINT fk_tbavaliacao_perguntasetor;
       public          postgres    false    215    215    4666    218    218            A           2606    33254    tbperguntasetor fk_tbpergunta    FK CONSTRAINT     �   ALTER TABLE ONLY public.tbperguntasetor
    ADD CONSTRAINT fk_tbpergunta FOREIGN KEY (percodigo) REFERENCES public.tbpergunta(percodigo) ON UPDATE CASCADE ON DELETE CASCADE;
 G   ALTER TABLE ONLY public.tbperguntasetor DROP CONSTRAINT fk_tbpergunta;
       public          postgres    false    4664    218    217            B           2606    33259    tbperguntasetor fk_tbsetor    FK CONSTRAINT     �   ALTER TABLE ONLY public.tbperguntasetor
    ADD CONSTRAINT fk_tbsetor FOREIGN KEY (setcodigo) REFERENCES public.tbsetor(setcodigo) ON UPDATE CASCADE ON DELETE CASCADE;
 D   ALTER TABLE ONLY public.tbperguntasetor DROP CONSTRAINT fk_tbsetor;
       public          postgres    false    218    219    4668            �     x�}�Kr[�D��*�s�E�{닙�!�'h�F�H� ���CoCsU�*Y	���O���wE]I�ȫ�:���}��qe+i����׺���qYt9�����L��ռ��S�u�
���{��V�b�ĪҮ���ɊOU�V�~t����y�o�8>�6�D�ֹ��%Z	>��m�:��Uz�Hќ��Ȗ��d1��}_@d��������)6Y�HE��u�-Ϳ�S�6�%K��U5�<��8��2����~�??��ϗ����m������׿m�^�+�N��ew9|?�7����o���=�� [s������c���߫|��<Η��}~8Կ�6Ǉ���������azh����<�_.�s]���r<��j^N�U��]MP+��F_�Juљ����Z�7{ڸ�5�7�cI]�vKQY2���k���Ꟈ�����O��?N����쫇��G���}��p���r���qS7u�_�q�/�*�W��oU������6������������K�)In�x[�����:�i�����p�}��џ^��|������vat�>o5,>������@� U��,��{���z�=�������qW���t#�Pop	��T���W���C�:K/�ƛ.|UY�DrKL�;�U�c4�å�������VO?��|�rx8���*�z-�J	Z�s��܆}�.��l����)店w�N%�5뺼�~ǽ2�[e�8�	� �L�A`�	t$&�A����B���sL�G�ҥQ��tqT07]�N�G��٨`�:�Q'�b�ԕO�F��iU��L�6��L�6��L�6��L�6��L�6��L�6��L�6��L�6��0Ou�T��2z��S=U��yQ��zQ����/L1z���1����1����1����1���SȾ1O!��<����o�SȾ1O!��<����o�SȾ͞�O��ӌ��gO3���=��~�4c;��ӌ��gO3���=��~�4c;��ӌ������y
�����y
�����y
�����y
�����y
�����y
�����y
�����y
�����y
�����y
����q�4a;��ӄ�fO�C�=M�i�4a;��ӄ�fO�C�=M�i�4a;��ӄ퐘���y
퐙���y
퐙���y
퐙���y
퐙���y
퐙���y
�0�SU@;� ���3A5���PM1z:3TS������3E5���QM1z:sTS���Q.B�u横��3G5E����3G5E����3G5�������"d_	GEȾ���}%!�J8*B��pT��+��W�Q����"d_	GEȾ���}%!�J8*B��pT��+��W�Q����"d_	GEȾ���}%!�J8*B��pT���
�d����ᨀ�@8*`;�
����ᨀ�@8*`;�
����ᨀ�@8*`;�
����ᨀ�@8*`;�
����ᨀ�@8*`;�
����ᨀ�@8*`;�
����ᨀ�@8*`;�
����ᨀ�@8�c�	Gy�>�(��'�1���<f�p�����}�Q�O8�c�	Gy�>�(��'�1���<f�p�����}�Q�O8�c�	Gy�>�(��'�1���<f�p�����}�Q�O8�c�	Gy�>�(��'�1���<f�p����2|2 e���ہp�a;�2l�Q��@8ʰG��(�v0�Q�`����G���2h#e�F8ʠ�p�A;�(�v0�Q�`����G���2h#e�F8ʠ�p�A;�(�v0�Q�`����G���2h#e�F8ʠ�p�B��p�B��p�B��p�B��p�B��p�B��p�b�	G)&�p�b�	G)&�p�b�	G)&�p�b�	G)&�p�b�	G)&�p�b�	G)&�p�b�	G)&�p�b�	G)&�p�b�	G)&�p�b�	G)&�p�b�	G)&�p�b�	G	���(��}#%���ہp�`;�l�Q��@8J�G	��(�v %���ہp�`;�l�Q��@8J�G	��(�v %���ہp�`;�l�Q��@8J�G	��(�v %���ہp�`;�l�Q���9j:�ڱN�>,9��Ç�R��r�S�o¸8��*���auٟ/��⸕v�ъ���ӗ��I՗.~[�}u��T�_͇����V�R���宻��MXD��B����|Lѷ��G0m�W����MZ{���U���ۿ��4�{���b�ۘTW�eΡ�b?���M_uR��Q�<�u���o�"9�.���D�͜�����µ�~����KMa���MLu�n8j��n;ǅA�i��U������p�u`��Hښl5-�E��/�:?���K���J��xX� ̾��~�8���Z�[�|
R|����iЫ�x�SZ[������{}��vͷ���!�������wW��*�Z��7H��P�"l�_RRWb���	�1KiS�G#JiG�%I~0��E��b��}�_�������������]�z�$h�|N����f��/�V�Ca��A���oy#¾+�T�UH7C��n��Y�^�u����%ܟ:������D���]Ds�]xw�.l�ٻ�e2хz�g�Zc�2�������b�/+�7��M��R	/Z�»Swa*��0v�ݩ�����e�p��7a}����O��b.�.�VKa���\�Į�V�q]����r�8���BCkY䮛�L~	eq9��p�QB�uD���-k��VZ���UW�R����\�i��_���P>����^��Fքw7݅!���L]�v&����^����dD�      �   Z   x�3�4�IL�I-QJMN-8����|NC.#�xh�'��1B�9'3/39�Ә�!蘛T�sxQ^rf"�	�)B" 5%3��(l����� �?"      �     x�u��J1��ݧ�R��[�\c'Zle3$�{��2I��m�|���I�BP!B&�|�ˮ��,p�?�8�G6�� ����|��n�_uC+�!*F�FfP
q XT|d��ۃ��9x����6��Z�/C���`��i�+�M�@��ښ�F>�z']A�Q%o���?�,���y���PW1Ke�����M�/��ЏA�P*Q6f��B��ɲ�6����#9XD!$,a��\lZ��[���Z:|#�	�`dwhn8%Ԓ��Ox����N���      �   8   x�-��  ���0H=˰�T+����,��¶i(�hD#a7������
|      �   ^   x�3�JMN-8����|NC.cN��k�2��S�s�B&���I�9��%g&�8CC<��)g@jJfbIQf"�g��{xeJfr>�W� a��      �   6   x�3�LL����42426J3�4O4�DscK�D�T�DôdcNC�=... -$b     