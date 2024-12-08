PGDMP  $    6            
    |            hrav    16.3    16.3     �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
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
    public          postgres    false    216   _-       �          0    33214 
   tbpergunta 
   TABLE DATA           F   COPY public.tbpergunta (percodigo, perpergunta, perativo) FROM stdin;
    public          postgres    false    217   �-       �          0    33220    tbperguntasetor 
   TABLE DATA           I   COPY public.tbperguntasetor (percodigo, setcodigo, pstativo) FROM stdin;
    public          postgres    false    218   �.       �          0    33224    tbsetor 
   TABLE DATA           D   COPY public.tbsetor (setcodigo, setdescricao, setativo) FROM stdin;
    public          postgres    false    219   //       �          0    33228 	   tbusuario 
   TABLE DATA           K   COPY public.tbusuario (usucodigo, usunome, ususenha, usuativo) FROM stdin;
    public          postgres    false    220   �/       4           2606    33233    tbavaliacao pk_tbavaliacao 
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
       public          postgres    false    218    219    4668            �   ^  x�}��r�D��W`�VGս���K/&��w�`Hh"!��G^�7�c�U �JT�!�C�A=�;�+y��Gyx'�w�|Z���y���V��q,�R\]��U7R�\BN�JF���o)�q�J����N�S^��a�!ڏ��_�������/�G��8�Ѻ$�1�U�nY����_�d1�ly�$dMqe�Ҁ�6gț K4sjX�K�	�x]Z��S�&���T��e��z[��	�e=�^��ϻ��a���{������_�ϯ{������=�N�����������M�uK0�U��^�v�_o�O����_�������p<���嗻����~�ۯl�������p�5lO�χ���������zwZ�j�h�}5�U�%�ZW^��j����卪��KJ5w����XV�����h����?����'[�����^w����c|9�?j;ܽ�?��yXۦ��s���h��ܝ�����m׏��������E��ʒJξ�E�/����;����p��?o��m��ח�"77��o�P��P6�ks�q���ްܰ�6ܯ��n��{�N������ik�LK��QB����K�������8��R���u����h�e�/�1��p.��ڇ���W�j������/�����;�|��k��Xk���!���v\y�d?�r.�������)��o���G�s�*H�� 2@ 1@ 3�@a��J W�9F��`Z�<LL�F����H09]	��ӑ`�:	���#1I��'u#1ij����I�F���I�F���I�F���I�F���I�F���I�F���I�F���I�F��z����z��5��5���y/L���^����-_1j*L���^����0MG�{a�����4�+���LS�2M���4�+���LS�2M���4��i��@̚L�0kZ0¬i�t���!̚L�0kZ0¬i�t���!̚L��4�tLSH��4�t�LSH��4�t�LSH��4�t�LSH��4�t�LSH��4�t�LSH��4�tHLSH��4�tHLSH��4�tHLSH��4�tHLSH��4�tH���!ϚfL�<k�1�i�tȳ��!ϚfL�<k�1�i�tȳ��!ϚfL��4�t(LSH��4�t(LSH��4�t(LSH��4�t(LSH��4�t(LSH��4�t�LSH��?�0�F������s�jĨ�ܡ1j:��F���-���s�jĨ�ܣ1h*s�r	�/s�2b���=�e$fMx_�Ո4��	�/s�jD�Y��ңx_H�J�}!=*������ңx_H�J�}!=*������ңx_H�J�}!=*������ңx_H�J�}!=*������ңx_H�J�}!=*������ңx_H�J�}ң"������@zT�t =*b:�1H����GELң"��QӁ����@zT�t =*b:�1H����GELң"��QӁ����@zT�t =*b:�1H����GELң"��QӁ����@zT�t =*b:�1H����GELңz�����'=*��I�
�}ңz�����'=*��I�
�}ңz�����'=*��I�
�}ңz�����'=*��I�
�}ңz�����'=*��I�
�}ңz�����'=*��I�
�}ңz�����'=*��I�
�}ңz�����'=J�d@z�b:����G)��Q��@z�b:����G)��Q
頤G)�����Jz�B:(�Q
頤G)�����Jz�B:(�Q
頤G)�����Jz�B:(�Q
頤G)�����Jz�B:(�Q
頤G)�����Jz�B:(�Q
頤G)�����Jz�����(g+�Q�Vң���G	8[I�p��%�lң�Mz���I�t6�Q��&=J�٤G	:��(Ag�%�lң�Mz���I�t6�Q��&=J�٤G	:��(Ag�%�lң�Mz���I�t6�Q��&=J�٤G	:��(�}%=��s_I���GyLң<��QӁ�(��@z��t =�c:��1H���GyLң<��QӁ�(��@z��t =�c:��1H���GyLң<��QӁ�(��@z��t =�c:��1H���GyLң<��QӁ�(���{��pn�u��	q)9f������J�[��`Z�s��:u|8�N��-�6���5\����#8�����%ܧs�x�����t�������i��=�`����u��)��&���������Z��ש��K����[�
s�`��k�`��I9���D�Rs9���p�n4,^��`�R�扯`�%�ʇ�d/�f�]ni��µ��~u{�7.��k���\�'����s��;i`�jn��w�ϻ������y�~#y�.�r��E�Q�w�,�}�����,����6q������B�������Ӡ�Wr^i��m�û�����ob{�6�R;w�3r����.�������_�C�f�%gq5u�l�L���k�Z>���
�Ͼ��(n�vZ�f������?���n;~�}�!�kdW�G韘��	���C�Շ�!X��N��7�]y�5]@b����v���������5ޟ:������D����^J*�;u���|K�B�h�yq�%f�)3�5ض/~0sLv_Zqo2���.��^����Sw0W;�ޝ�@�X,e"���ݗj?�E��:x���8[b�ɧ�]�E9Wbq�m�^'η\t�baQ:7?L~�~q%�;8g�Ƙ��������v�,�:xg�ζb�޹�3�+�v�6�4sۋ]>{�5��;��p�Mn��2�@�F��b�p�n��ڗ?�qӷ\�&�{;��zD����wN6�,�ט/��Nn@� ���"M�po�`WE��V�C�������Ζ߸�s����s�U{Zܵ��44�O�Vgg��-�}�bω�A�sMhK4ۻ�;x$��ɓ:xM�`�v́3pZ��v%�~0s%�b�[�b���\�����������'�36�C{b�ZT�'j7�=��\�9X܂v�l��?�0�v��'����ۣ�-h�w?���Վ �0��O06#�=�s龍�w_�����=]�f��=�O�?������v���&5��/+���.��W�^V�����u      �   Z   x�3�4�IL�I-QJMN-8����|NC.#�xh�'��	B�17�4����DN.c��sNf^fr"�1�)B0 5%3���֔+F��� �"      �     x�uпJ1�z�)��F8��"�؉W����@6�L�+|����"/�l�BP!������t[�����)���0S�<Q�r�m��n��aȊ���	��L�f�������#�ɮ:!�e�`����E���Ř�V�����]���~�5O���I�HLu9P�YRAs�TBƵ���7�,%\��HaFE�8�ǂ�Q��{��OW�-fO�к���l�-�a ov�J�qc�tυ J�o�o�&x|yحS�}�����      �   8   x�-��  ���0H=˰�T+����,��¶i(�hD#a7������
|      �   ^   x�3�JMN-8����|NC.cN��k�2��S�s�B&���I�9��%g&�8CC<��)g@jJfbIQf"�g��{xeJfr>�W� a��      �   6   x�3�LL����42426J3�4O4�DscK�D�T�DôdcNC�=... -$b     