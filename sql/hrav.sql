PGDMP     &    0        
        |            hrav    14.9    15.4                0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false                       0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false                       0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false                       1262    16466    hrav    DATABASE     {   CREATE DATABASE hrav WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Portuguese_Brazil.1252';
    DROP DATABASE hrav;
                postgres    false                        2615    2200    public    SCHEMA     2   -- *not* creating schema, since initdb creates it
 2   -- *not* dropping schema, since initdb creates it
                postgres    false                       0    0    SCHEMA public    ACL     Q   REVOKE USAGE ON SCHEMA public FROM PUBLIC;
GRANT ALL ON SCHEMA public TO PUBLIC;
                   postgres    false    4            �            1259    24829    tbavaliacao    TABLE       CREATE TABLE public.tbavaliacao (
    avacodigo bigint NOT NULL,
    percodigo bigint NOT NULL,
    setcodigo bigint NOT NULL,
    discodigo bigint NOT NULL,
    avaresposta smallint NOT NULL,
    avafeedback text,
    avadatahora timestamp without time zone DEFAULT now()
);
    DROP TABLE public.tbavaliacao;
       public         heap    postgres    false    4            �            1259    16544    tbdispositivo    TABLE     �   CREATE TABLE public.tbdispositivo (
    discodigo bigint NOT NULL,
    disstatus smallint DEFAULT 0 NOT NULL,
    disnome character varying(200) NOT NULL,
    setcodigo bigint
);
 !   DROP TABLE public.tbdispositivo;
       public         heap    postgres    false    4            �            1259    16473 
   tbpergunta    TABLE     �   CREATE TABLE public.tbpergunta (
    percodigo bigint NOT NULL,
    perpergunta text NOT NULL,
    perativo smallint DEFAULT 0
);
    DROP TABLE public.tbpergunta;
       public         heap    postgres    false    4            �            1259    16647    tbperguntasetor    TABLE     �   CREATE TABLE public.tbperguntasetor (
    percodigo bigint NOT NULL,
    setcodigo bigint NOT NULL,
    pstativo smallint DEFAULT 0 NOT NULL
);
 #   DROP TABLE public.tbperguntasetor;
       public         heap    postgres    false    4            �            1259    16467    tbsetor    TABLE     �   CREATE TABLE public.tbsetor (
    setcodigo bigint NOT NULL,
    setdescricao character varying(200) NOT NULL,
    setativo smallint DEFAULT 0
);
    DROP TABLE public.tbsetor;
       public         heap    postgres    false    4            �            1259    41150 	   tbusuario    TABLE     �   CREATE TABLE public.tbusuario (
    usucodigo bigint NOT NULL,
    usunome character varying(50) NOT NULL,
    ususenha character varying(32) NOT NULL,
    usuativo smallint DEFAULT 0 NOT NULL
);
    DROP TABLE public.tbusuario;
       public         heap    postgres    false    4                      0    24829    tbavaliacao 
   TABLE DATA           x   COPY public.tbavaliacao (avacodigo, percodigo, setcodigo, discodigo, avaresposta, avafeedback, avadatahora) FROM stdin;
    public          postgres    false    213   �                  0    16544    tbdispositivo 
   TABLE DATA           Q   COPY public.tbdispositivo (discodigo, disstatus, disnome, setcodigo) FROM stdin;
    public          postgres    false    211   -                 0    16473 
   tbpergunta 
   TABLE DATA           F   COPY public.tbpergunta (percodigo, perpergunta, perativo) FROM stdin;
    public          postgres    false    210   �-                 0    16647    tbperguntasetor 
   TABLE DATA           I   COPY public.tbperguntasetor (percodigo, setcodigo, pstativo) FROM stdin;
    public          postgres    false    212   �.                 0    16467    tbsetor 
   TABLE DATA           D   COPY public.tbsetor (setcodigo, setdescricao, setativo) FROM stdin;
    public          postgres    false    209   �.                 0    41150 	   tbusuario 
   TABLE DATA           K   COPY public.tbusuario (usucodigo, usunome, ususenha, usuativo) FROM stdin;
    public          postgres    false    214   Y/       ~           2606    24836    tbavaliacao pk_tbavaliacao 
   CONSTRAINT     j   ALTER TABLE ONLY public.tbavaliacao
    ADD CONSTRAINT pk_tbavaliacao PRIMARY KEY (avacodigo, percodigo);
 D   ALTER TABLE ONLY public.tbavaliacao DROP CONSTRAINT pk_tbavaliacao;
       public            postgres    false    213    213            z           2606    16549    tbdispositivo pk_tbdispositivo 
   CONSTRAINT     c   ALTER TABLE ONLY public.tbdispositivo
    ADD CONSTRAINT pk_tbdispositivo PRIMARY KEY (discodigo);
 H   ALTER TABLE ONLY public.tbdispositivo DROP CONSTRAINT pk_tbdispositivo;
       public            postgres    false    211            x           2606    16480    tbpergunta pk_tbpergunta 
   CONSTRAINT     ]   ALTER TABLE ONLY public.tbpergunta
    ADD CONSTRAINT pk_tbpergunta PRIMARY KEY (percodigo);
 B   ALTER TABLE ONLY public.tbpergunta DROP CONSTRAINT pk_tbpergunta;
       public            postgres    false    210            |           2606    16651 "   tbperguntasetor pk_tbperguntasetor 
   CONSTRAINT     r   ALTER TABLE ONLY public.tbperguntasetor
    ADD CONSTRAINT pk_tbperguntasetor PRIMARY KEY (percodigo, setcodigo);
 L   ALTER TABLE ONLY public.tbperguntasetor DROP CONSTRAINT pk_tbperguntasetor;
       public            postgres    false    212    212            v           2606    16472    tbsetor pk_tbsetor 
   CONSTRAINT     W   ALTER TABLE ONLY public.tbsetor
    ADD CONSTRAINT pk_tbsetor PRIMARY KEY (setcodigo);
 <   ALTER TABLE ONLY public.tbsetor DROP CONSTRAINT pk_tbsetor;
       public            postgres    false    209            �           2606    41155    tbusuario pk_tbusuario 
   CONSTRAINT     [   ALTER TABLE ONLY public.tbusuario
    ADD CONSTRAINT pk_tbusuario PRIMARY KEY (usucodigo);
 @   ALTER TABLE ONLY public.tbusuario DROP CONSTRAINT pk_tbusuario;
       public            postgres    false    214            �           2606    24842 &   tbavaliacao fk_tbavaliacao_dispositivo    FK CONSTRAINT     �   ALTER TABLE ONLY public.tbavaliacao
    ADD CONSTRAINT fk_tbavaliacao_dispositivo FOREIGN KEY (discodigo) REFERENCES public.tbdispositivo(discodigo);
 P   ALTER TABLE ONLY public.tbavaliacao DROP CONSTRAINT fk_tbavaliacao_dispositivo;
       public          postgres    false    211    213    3194            �           2606    32958 (   tbavaliacao fk_tbavaliacao_perguntasetor    FK CONSTRAINT     �   ALTER TABLE ONLY public.tbavaliacao
    ADD CONSTRAINT fk_tbavaliacao_perguntasetor FOREIGN KEY (percodigo, setcodigo) REFERENCES public.tbperguntasetor(percodigo, setcodigo) ON UPDATE CASCADE;
 R   ALTER TABLE ONLY public.tbavaliacao DROP CONSTRAINT fk_tbavaliacao_perguntasetor;
       public          postgres    false    213    212    212    213    3196            �           2606    16652    tbperguntasetor fk_tbpergunta    FK CONSTRAINT     �   ALTER TABLE ONLY public.tbperguntasetor
    ADD CONSTRAINT fk_tbpergunta FOREIGN KEY (percodigo) REFERENCES public.tbpergunta(percodigo) ON UPDATE CASCADE ON DELETE CASCADE;
 G   ALTER TABLE ONLY public.tbperguntasetor DROP CONSTRAINT fk_tbpergunta;
       public          postgres    false    210    3192    212            �           2606    16657    tbperguntasetor fk_tbsetor    FK CONSTRAINT     �   ALTER TABLE ONLY public.tbperguntasetor
    ADD CONSTRAINT fk_tbsetor FOREIGN KEY (setcodigo) REFERENCES public.tbsetor(setcodigo) ON UPDATE CASCADE ON DELETE CASCADE;
 D   ALTER TABLE ONLY public.tbperguntasetor DROP CONSTRAINT fk_tbsetor;
       public          postgres    false    209    3190    212                 x�}��r����S���DwU���|�Aዎ�@�J�K��ב���S��\ݻ�'�9$%�|�Ι̙D��M?�͍�/1|�y�>�}JK2I�n�F�\�X��v��MT�K]J���6;!��|�$�%,*YZvJ5��`͊c�&�����=�v�ݯ�ǟ�_�>���%kK�o��eY-,��4[b�Z�)��&V4�[�g�WX�3��M��
�ܱt�1��m��}�)a��Rc5�f�WT�A�Y�v��__O�����iw|�v������׿�ߎ�7ߞ/�w��輪�a����oǇ�j��)�5,檫���X��<�;���=_^����追۝�O��?�s�����|z������|߻������ŏ��e���������~ԇ��Mmm��o�r9���(�s����.���_�Kέ�㒢X�P����j����}���/~Կ>���vpw�?���k���������?N;����������<�|sj����s��?=��}}����A���k)����8ؿ�~>��ϻ?N/ߎ�w_w�����É/Q��6�](ݯս��R�Ns��c):V:Vޗ�y��;��������p��L�tY�Z�<��Cj{MK(���9��I��|�|Yo:�)9�YkwL�\��YΪc�rm�$�b�3�����t��x��CQ�~.��ZK���8��e�OC��!���r)���)#>QQL�ܶ��>�xDf�M�W�2 � c���� ]��
�
�+� ��1F�5��eM01C^L͐��3ؚ`z]L� k�)⚘$틆51iꄬ5����Xk'M;��4N�vb�i�4��Z�8iډ��qҴkM�i'֚�I�N�5�LSYk��q��0M�ZSa��=�i�6}�����/�Xk*Lӵ�0M�Ə�4];?
�tm�(LS�2M���4�+���LS�2M���4�+���LS�Κ�/
Ĭi�t�Yӊ�`����fM+��͚VL�5��6kZ1lִb:جi�t0�)��1M!��!1M!��!1M!��!1M!��!1M!��!1M!2��!3M!2��!3M!2��!3M!2��!3M!2��!ϚL�2kZ0ʬi�t(��ӡ̚L�2kZ0ʬi�t(��ӡ̚L�2kZ0
�ҡ2M!*�ҡ2M!*�ҡ2M!*�ҡ2M!*�ҡ2M!*�ҡ1M!�����\�:��tnP�Xk:W�N�5�;T'֚�%�kM�Չ��s���ZӹGub���=*d��=ʉ��e�Q��kb�4��e�Q��kb�4��e�Q��51k���BzT��Q�/�Ge����BzT��Q�/�Ge����BzT��Q�/�Ge����BzT��Q�/�Ge����BzT��Q�/�Ge����BzT��Q�OzT�'!=*a:��0H�J��G%Lң��Q	Ӂ����@zT�t =*a:��0H�J��G%Lң��Q	Ӂ����@zT�t =*a:��0H�J��G%Lң��Q	Ӂ����@zT�t =*a:��0H�J��G%Lң��Q	Ӂ�(C�e�}ң�Oz���I�2�>�Q��'=����Gz��(C�e�}ң�Oz���I�2�>�Q��'=����Gz��(C�e�}ң�Oz���I�2�>�Q��'=����Gz��(C�e�}ң�Oz���I�2�>�Q��'=J�ɀ�(�t =J1H�RLңӁ�(�t =J1H�RLң�AI�RH%=J!��(�tPң�AI�RH%=J!��(�tPң�AI�RH%=J!��(�tPң�AI�RH%=J!��(�tPң�AI�RH%=J!��(�tPң�AI�RH%=J!��(g+�Q�Vң���G	8[I�p��%�l%=J�٤G	:��(Ag�%�lң�Mz���I�t6�Q��&=J�٤G	:��(Ag�%�lң�Mz���I�t6�Q��&=J�٤G	:��(Ag�%�lң�Mz���I�t6�Q��JzT����1H����GELң"��QӁ����@zT�t =*b:�1H����GELң"��QӁ����@zT�t =*b:�1H����GELң"��QӁ����@zT�t =*b:�1H����GELң"��Q�a�����_�ioi�%��LW��{
u���0/!����/)��>��O�A��&_�c=/x��8g�d�Ν_iTX���_b��.9��y�e��s.L�ɹ<^��N�\l{�%�x�\�<��X�P��R�h�\�6�޲����{�i1�C��]NK�`�1H�x�Sa�:��T����4(�JU��W�q�n�g�]��ѽs)/Vc6@r�V`���\s��/�6�k��V���6x�6м���m�=s�rW���-���R[˪ܜ<��K+2������%x�.}�\�d)%w#7�6�9�T�:���6?+���\���qd�K�J��z�Lb�?��b�m�Ý8�Wb����u��������.�qȘ�W�Yʭ�:o�8^�O!�t7W<�%�n�V�W�!��:������w]Gf�sd�Pz0�}��$H<Sᜟ��~�O`n#;Ƿk6A�K.w�H��%i���dm~�*��)��`��I�j{����1����B��m>���$u0^Oz�������:���������_�ּ�;(��u��^Z皝���� �Q:�8����#�f��ͰMП2B�e�WF;͛`���l~���v=�>�=g�BC�9y��%��m\���A6�y��L�ԭ�X0]�A��6�+��֢�-g��؟������'����<@>��ۚt�l��~iW�zqpd�
�hi��ɺ��+���[��?��}<Z���|k�� ��
L�4�}�6�H/Q�y��YBL����g�W�J�|�ɚ��������r)�-��p�-�<�� �-��Vb��O��` &ip��/���t���/�?��ߟ4b�������O_!��@fm|��6�W�?��r�+;^������]�X�a��������xz�;����[�y�ǃ�ߞ�������Wx���Xnoo���D         Z   x�3�4�IL�I-QJMN-8����|NC.#�xh�'��1B�9'3/39�Ә�!蘛T�sxQ^rf"�	�)B" 5%3��(l����� �?"           x�u�=N1F��)\B�X~�Պ�A1��xf#e⑓l�mFT��)r1<Y
$@���{��}k�A�p`[?��x����e�oͦ�1<�w�L�޶$B]�A�7�����Þ��p,(ګ��):?Q̼5�ݵ�[���`F�`y�4���p����\���eZEFI�S��7i��L����~8l����y���-AE�4r�����|=*�b�S[�h=���i�*�'����T��[n�sLu9P��RA=IL%���z�u��ݝ�         8   x�-��  ���0H=˰�T+����,��¶i(�hD#a7������
|         ^   x�3�JMN-8����|NC.cN��k�2��S�s�B&���I�9��%g&�8CC<��)g@jJfbIQf"�g��{xeJfr>�W� a��         6   x�3�LL����42426J3�4O4�DscK�D�T�DôdcNC�=... -$b     