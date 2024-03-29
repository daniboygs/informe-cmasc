USE [master]
GO
/****** Object:  Database [informe_cmasc]    Script Date: 12/04/2021 11:20:07 ******/
CREATE DATABASE [informe_cmasc]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'informe_cmasc', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL13.SQLEXPRESS\MSSQL\DATA\informe_cmasc.mdf' , SIZE = 8192KB , MAXSIZE = UNLIMITED, FILEGROWTH = 65536KB )
 LOG ON 
( NAME = N'informe_cmasc_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL13.SQLEXPRESS\MSSQL\DATA\informe_cmasc_log.ldf' , SIZE = 8192KB , MAXSIZE = 2048GB , FILEGROWTH = 65536KB )
GO
ALTER DATABASE [informe_cmasc] SET COMPATIBILITY_LEVEL = 120
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [informe_cmasc].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [informe_cmasc] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [informe_cmasc] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [informe_cmasc] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [informe_cmasc] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [informe_cmasc] SET ARITHABORT OFF 
GO
ALTER DATABASE [informe_cmasc] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [informe_cmasc] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [informe_cmasc] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [informe_cmasc] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [informe_cmasc] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [informe_cmasc] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [informe_cmasc] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [informe_cmasc] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [informe_cmasc] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [informe_cmasc] SET  DISABLE_BROKER 
GO
ALTER DATABASE [informe_cmasc] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [informe_cmasc] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [informe_cmasc] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [informe_cmasc] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [informe_cmasc] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [informe_cmasc] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [informe_cmasc] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [informe_cmasc] SET RECOVERY SIMPLE 
GO
ALTER DATABASE [informe_cmasc] SET  MULTI_USER 
GO
ALTER DATABASE [informe_cmasc] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [informe_cmasc] SET DB_CHAINING OFF 
GO
ALTER DATABASE [informe_cmasc] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [informe_cmasc] SET TARGET_RECOVERY_TIME = 0 SECONDS 
GO
ALTER DATABASE [informe_cmasc] SET DELAYED_DURABILITY = DISABLED 
GO
ALTER DATABASE [informe_cmasc] SET QUERY_STORE = OFF
GO
USE [informe_cmasc]
GO
ALTER DATABASE SCOPED CONFIGURATION SET MAXDOP = 0;
GO
ALTER DATABASE SCOPED CONFIGURATION FOR SECONDARY SET MAXDOP = PRIMARY;
GO
ALTER DATABASE SCOPED CONFIGURATION SET LEGACY_CARDINALITY_ESTIMATION = OFF;
GO
ALTER DATABASE SCOPED CONFIGURATION FOR SECONDARY SET LEGACY_CARDINALITY_ESTIMATION = PRIMARY;
GO
ALTER DATABASE SCOPED CONFIGURATION SET PARAMETER_SNIFFING = ON;
GO
ALTER DATABASE SCOPED CONFIGURATION FOR SECONDARY SET PARAMETER_SNIFFING = PRIMARY;
GO
ALTER DATABASE SCOPED CONFIGURATION SET QUERY_OPTIMIZER_HOTFIXES = OFF;
GO
ALTER DATABASE SCOPED CONFIGURATION FOR SECONDARY SET QUERY_OPTIMIZER_HOTFIXES = PRIMARY;
GO
USE [informe_cmasc]
GO
/****** Object:  User [daniel]    Script Date: 12/04/2021 11:20:10 ******/
CREATE USER [daniel] FOR LOGIN [daniel] WITH DEFAULT_SCHEMA=[dbo]
GO
ALTER ROLE [db_owner] ADD MEMBER [daniel]
GO
ALTER ROLE [db_datareader] ADD MEMBER [daniel]
GO
ALTER ROLE [db_datawriter] ADD MEMBER [daniel]
GO
/****** Object:  Schema [cat]    Script Date: 12/04/2021 11:20:12 ******/
CREATE SCHEMA [cat]
GO
/****** Object:  Schema [cmasc]    Script Date: 12/04/2021 11:20:12 ******/
CREATE SCHEMA [cmasc]
GO
/****** Object:  Schema [delitos]    Script Date: 12/04/2021 11:20:12 ******/
CREATE SCHEMA [delitos]
GO
/****** Object:  Schema [inegi]    Script Date: 12/04/2021 11:20:12 ******/
CREATE SCHEMA [inegi]
GO
/****** Object:  Schema [senap]    Script Date: 12/04/2021 11:20:12 ******/
CREATE SCHEMA [senap]
GO
/****** Object:  Table [cat].[Delito]    Script Date: 12/04/2021 11:20:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [cat].[Delito](
	[DelitoID] [int] IDENTITY(1,1) NOT NULL,
	[Nombre] [nvarchar](150) NULL,
	[Art] [nvarchar](50) NULL,
	[ModalidadID] [int] NULL,
 CONSTRAINT [PK_Delito_1] PRIMARY KEY CLUSTERED 
(
	[DelitoID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [cat].[Entidad]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [cat].[Entidad](
	[EntidadID] [int] IDENTITY(1,1) NOT NULL,
	[Nombre] [nvarchar](50) NULL,
	[Clave] [nchar](2) NULL,
 CONSTRAINT [PK_Entidad] PRIMARY KEY CLUSTERED 
(
	[EntidadID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [cat].[Escolaridad]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [cat].[Escolaridad](
	[EscolaridadID] [int] IDENTITY(1,1) NOT NULL,
	[Nombre] [nvarchar](100) NULL,
 CONSTRAINT [PK_Escolaridad] PRIMARY KEY CLUSTERED 
(
	[EscolaridadID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [cat].[Fiscalia]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [cat].[Fiscalia](
	[FiscaliaID] [int] IDENTITY(1,1) NOT NULL,
	[Nombre] [nvarchar](50) NULL,
 CONSTRAINT [PK_Fiscalia] PRIMARY KEY CLUSTERED 
(
	[FiscaliaID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [cat].[Instrumento]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [cat].[Instrumento](
	[InstrumentoID] [int] IDENTITY(1,1) NOT NULL,
	[Nombre] [nvarchar](100) NULL,
 CONSTRAINT [PK_Instrumento] PRIMARY KEY CLUSTERED 
(
	[InstrumentoID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [cat].[Modalidad]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [cat].[Modalidad](
	[ModalidadID] [int] IDENTITY(1,1) NOT NULL,
	[Nombre] [nvarchar](30) NULL,
 CONSTRAINT [PK_Modalidad] PRIMARY KEY CLUSTERED 
(
	[ModalidadID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [cat].[Municipio]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [cat].[Municipio](
	[MunicipioID] [int] IDENTITY(1,1) NOT NULL,
	[Nombre] [nvarchar](30) NULL,
	[FiscaliaID] [int] NULL,
	[MunicipioPaisID] [int] NULL,
 CONSTRAINT [PK_Municipio] PRIMARY KEY CLUSTERED 
(
	[MunicipioID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [cat].[Ocupacion]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [cat].[Ocupacion](
	[OcupacionID] [int] IDENTITY(1,1) NOT NULL,
	[Nombre] [nvarchar](250) NULL,
 CONSTRAINT [PK_Ocupacion] PRIMARY KEY CLUSTERED 
(
	[OcupacionID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [cat].[Seccion]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [cat].[Seccion](
	[SeccionID] [int] NOT NULL,
	[Nombre] [nvarchar](50) NULL,
 CONSTRAINT [PK_Seccion] PRIMARY KEY CLUSTERED 
(
	[SeccionID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [cat].[TipoConclusion]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [cat].[TipoConclusion](
	[TipoConclusionID] [int] IDENTITY(1,1) NOT NULL,
	[Nombre] [nvarchar](150) NULL,
 CONSTRAINT [PK_TipoConclusion] PRIMARY KEY CLUSTERED 
(
	[TipoConclusionID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [cat].[TipoReparacion]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [cat].[TipoReparacion](
	[TipoReparacionID] [int] IDENTITY(1,1) NOT NULL,
	[Nombre] [nvarchar](150) NULL,
 CONSTRAINT [PK_TipoReparacion] PRIMARY KEY CLUSTERED 
(
	[TipoReparacionID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [cat].[Turnado]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [cat].[Turnado](
	[TurnadoID] [int] IDENTITY(1,1) NOT NULL,
	[Nombre] [nvarchar](150) NULL,
 CONSTRAINT [PK_Turnado] PRIMARY KEY CLUSTERED 
(
	[TurnadoID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [cat].[Unidad]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [cat].[Unidad](
	[UnidadID] [int] IDENTITY(1,1) NOT NULL,
	[Nombre] [nvarchar](50) NULL,
 CONSTRAINT [PK_Unidad] PRIMARY KEY CLUSTERED 
(
	[UnidadID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[AcuerdosCelebrados]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[AcuerdosCelebrados](
	[AcuerdoCelebradoID] [int] IDENTITY(1,1) NOT NULL,
	[Fecha] [date] NULL,
	[AcuerdoDelito] [nvarchar](50) NULL,
	[Intervinientes] [int] NULL,
	[NUC] [nvarchar](13) NULL,
	[Cumplimiento] [nvarchar](50) NULL,
	[TotalParcial] [tinyint] NULL,
	[Mecanismo] [nvarchar](50) NULL,
	[MontoRecuperado] [int] NULL,
	[MontoEspecie] [nvarchar](70) NULL,
	[Unidad] [nvarchar](50) NULL,
	[UsuarioID] [int] NULL,
 CONSTRAINT [PK_AcuerdosCelebrados] PRIMARY KEY CLUSTERED 
(
	[AcuerdoCelebradoID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[CarpetasEnviadasInvestigacion]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[CarpetasEnviadasInvestigacion](
	[CarpetaEnviadaInvestigacionID] [int] IDENTITY(1,1) NOT NULL,
	[Fecha] [date] NULL,
	[NUC] [nvarchar](13) NULL,
	[Delito] [nvarchar](50) NULL,
	[Unidad] [nvarchar](50) NULL,
	[MotivoCancelacion] [nvarchar](100) NULL,
	[UsuarioID] [int] NULL,
 CONSTRAINT [PK_CarpetasEnviadasInvestigacion] PRIMARY KEY CLUSTERED 
(
	[CarpetaEnviadaInvestigacionID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[CarpetasEnviadasValidacion]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[CarpetasEnviadasValidacion](
	[CarpetaEnviadaValidacionID] [int] IDENTITY(1,1) NOT NULL,
	[Fecha] [date] NULL,
	[NUC] [nvarchar](13) NULL,
	[Delito] [nvarchar](50) NULL,
	[Unidad] [nvarchar](50) NULL,
	[UsuarioID] [int] NULL,
 CONSTRAINT [PK_CarpetasEnviadasValidacion] PRIMARY KEY CLUSTERED 
(
	[CarpetaEnviadaValidacionID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[CarpetasIngresadas]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[CarpetasIngresadas](
	[CarpetaIngresadaID] [int] IDENTITY(1,1) NOT NULL,
	[FechaIngreso] [date] NULL,
	[Delito] [nvarchar](50) NULL,
	[NUC] [nvarchar](13) NULL,
	[MPCanalizador] [nvarchar](50) NULL,
	[Unidad] [nvarchar](50) NULL,
	[CarpetaRecibida] [int] NULL,
	[Canalizador] [nvarchar](50) NULL,
	[Fiscalia] [nvarchar](50) NULL,
	[Municipio] [nvarchar](100) NULL,
	[Observaciones] [nvarchar](100) NULL,
	[FechaCarpetas] [date] NULL,
	[Facilitador] [int] NULL,
	[FechaLibro] [date] NULL,
	[UsuarioID] [int] NULL,
 CONSTRAINT [PK_CarpetasIngresadas] PRIMARY KEY CLUSTERED 
(
	[CarpetaIngresadaID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[CarpetasRecibidas]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[CarpetasRecibidas](
	[CarpetaRecibidaID] [int] IDENTITY(1,1) NOT NULL,
	[Fecha] [date] NULL,
	[NUC] [nvarchar](13) NULL,
	[Delito] [nvarchar](50) NULL,
	[Unidad] [nvarchar](50) NULL,
	[UsuarioID] [int] NULL,
 CONSTRAINT [PK_CarpetasRecibidas] PRIMARY KEY CLUSTERED 
(
	[CarpetaRecibidaID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[CarpetasTramite]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[CarpetasTramite](
	[CarpetaTramiteID] [int] IDENTITY(1,1) NOT NULL,
	[FechaInicio] [date] NULL,
	[FechaFin] [date] NULL,
	[NombreFacilitador] [nvarchar](100) NULL,
	[CarpetasInvestigacion] [int] NULL,
	[AtencionInmediata] [int] NULL,
	[CJIM] [int] NULL,
	[ViolenciaFamiliar] [int] NULL,
	[DelitosCiberneticos] [int] NULL,
	[Adolescentes] [int] NULL,
	[InteligenciaPatrimonial] [int] NULL,
	[AltoImpacto] [int] NULL,
	[DerechosHumanos] [int] NULL,
	[CombateCorrupcion] [int] NULL,
	[AsuntosEspeciales] [int] NULL,
	[AsuntosInternos] [int] NULL,
	[Litigacion] [int] NULL,
	[MedioAmbiente] [int] NULL,
	[UsuarioID] [int] NULL,
 CONSTRAINT [PK_CarpetasTramite] PRIMARY KEY CLUSTERED 
(
	[CarpetaTramiteID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[PeriodoCaptura]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[PeriodoCaptura](
	[PeriodoID] [int] IDENTITY(1,1) NOT NULL,
	[FechaInicio] [date] NULL,
	[FechaFin] [date] NULL,
	[CapturaDiaria] [bit] NULL,
	[Seccion] [int] NULL,
 CONSTRAINT [PK_PeriodoCaptura] PRIMARY KEY CLUSTERED 
(
	[PeriodoID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[PersonasAtendidas]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[PersonasAtendidas](
	[PersonaID] [int] IDENTITY(1,1) NOT NULL,
	[Fecha] [date] NULL,
	[NUC] [nvarchar](13) NULL,
	[Delito] [nvarchar](50) NULL,
	[PersonasAtendidas] [int] NULL,
	[Unidad] [nvarchar](50) NULL,
	[UsuarioID] [int] NULL,
 CONSTRAINT [PK_PersonasAtendidas] PRIMARY KEY CLUSTERED 
(
	[PersonaID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[Usuario]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Usuario](
	[UsuarioID] [int] IDENTITY(1,1) NOT NULL,
	[Usuario] [nvarchar](50) NULL,
	[Contrasena] [nvarchar](50) NULL,
	[Nombre] [nvarchar](50) NULL,
	[ApellidoPaterno] [nvarchar](50) NULL,
	[ApellidoMaterno] [nvarchar](50) NULL,
	[Tipo] [tinyint] NULL,
	[FiscaliaID] [int] NULL,
 CONSTRAINT [PK_Usuario] PRIMARY KEY CLUSTERED 
(
	[UsuarioID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [delitos].[AcuerdosCelebrados]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [delitos].[AcuerdosCelebrados](
	[DelitoAcuerdoID] [int] IDENTITY(1,1) NOT NULL,
	[DelitoID] [int] NULL,
	[AcuerdoCelebradoID] [int] NULL,
 CONSTRAINT [PK_AcuerdosCelebrados_1] PRIMARY KEY CLUSTERED 
(
	[DelitoAcuerdoID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [delitos].[CarpetasEnviadasInvestigacion]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [delitos].[CarpetasEnviadasInvestigacion](
	[DelitoCarpetaEnviadaInvestigacionID] [int] IDENTITY(1,1) NOT NULL,
	[DelitoID] [int] NULL,
	[CarpetaEnviadaInvestigacionID] [int] NULL,
 CONSTRAINT [PK_CarpetasEnviadasInvestigacion_1] PRIMARY KEY CLUSTERED 
(
	[DelitoCarpetaEnviadaInvestigacionID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [delitos].[CarpetasEnviadasValidacion]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [delitos].[CarpetasEnviadasValidacion](
	[DelitoCarpetaEnviadaValidacionID] [int] IDENTITY(1,1) NOT NULL,
	[DelitoID] [int] NULL,
	[CarpetaEnviadaValidacionID] [int] NULL,
 CONSTRAINT [PK_CarpetasEnviadasValidacion_1] PRIMARY KEY CLUSTERED 
(
	[DelitoCarpetaEnviadaValidacionID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [delitos].[CarpetasIngresadas]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [delitos].[CarpetasIngresadas](
	[DelitoCarpetaIngresadaID] [int] IDENTITY(1,1) NOT NULL,
	[DelitoID] [int] NULL,
	[CarpetaIngresadaID] [int] NULL,
 CONSTRAINT [PK_CarpetasIngresadas_1] PRIMARY KEY CLUSTERED 
(
	[DelitoCarpetaIngresadaID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [delitos].[CarpetasRecibidas]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [delitos].[CarpetasRecibidas](
	[DelitoCarpetaRecibidaID] [int] IDENTITY(1,1) NOT NULL,
	[DelitoID] [int] NULL,
	[CarpetaRecibidaID] [int] NULL,
 CONSTRAINT [PK_CarpetasRecibidas_1] PRIMARY KEY CLUSTERED 
(
	[DelitoCarpetaRecibidaID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [delitos].[INEGI]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [delitos].[INEGI](
	[DelitoInegiID] [int] IDENTITY(1,1) NOT NULL,
	[DelitoID] [int] NULL,
	[GeneralID] [int] NULL,
 CONSTRAINT [PK_INEGI_1] PRIMARY KEY CLUSTERED 
(
	[DelitoInegiID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [delitos].[PersonasAtendidas]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [delitos].[PersonasAtendidas](
	[DelitoPersonaAtendidaID] [int] IDENTITY(1,1) NOT NULL,
	[DelitoID] [int] NULL,
	[PersonaAtendidaID] [int] NULL,
 CONSTRAINT [PK_PersonasAtendidas_1] PRIMARY KEY CLUSTERED 
(
	[DelitoPersonaAtendidaID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [inegi].[Delito]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [inegi].[Delito](
	[DelitoInegiID] [int] IDENTITY(1,1) NOT NULL,
	[Calificacion] [nvarchar](10) NULL,
	[Concurso] [nvarchar](10) NULL,
	[FormaAccion] [nvarchar](20) NULL,
	[Comision] [nvarchar](20) NULL,
	[Violencia] [nvarchar](20) NULL,
	[Modalidad] [int] NULL,
	[Instrumento] [int] NULL,
	[JusticiaAlternativa] [bit] NULL,
	[DelitoID] [int] NULL,
	[GeneralID] [int] NULL,
 CONSTRAINT [PK_Delito] PRIMARY KEY CLUSTERED 
(
	[DelitoInegiID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [inegi].[General]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [inegi].[General](
	[GeneralID] [int] IDENTITY(1,1) NOT NULL,
	[NUC] [nvarchar](13) NULL,
	[Fecha] [date] NULL,
	[Delito] [nvarchar](100) NULL,
	[Unidad] [nvarchar](100) NULL,
	[Atendidos] [int] NULL,
	[CarpetaRecibidaID] [int] NULL,
	[AcuerdoCelebradoID] [int] NULL,
	[UsuarioID] [int] NULL,
 CONSTRAINT [PK_INEGI] PRIMARY KEY CLUSTERED 
(
	[GeneralID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [inegi].[Imputado]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [inegi].[Imputado](
	[ImputadoID] [int] IDENTITY(1,1) NOT NULL,
	[Sexo] [nvarchar](10) NULL,
	[Edad] [int] NULL,
	[Escolaridad] [int] NULL,
	[Ocupacion] [int] NULL,
	[Solicitante] [nvarchar](100) NULL,
	[Requerido] [nvarchar](100) NULL,
	[Tipo] [nvarchar](25) NULL,
	[GeneralID] [int] NULL,
 CONSTRAINT [PK_Imputado] PRIMARY KEY CLUSTERED 
(
	[ImputadoID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [inegi].[MASC]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [inegi].[MASC](
	[MASCID] [int] IDENTITY(1,1) NOT NULL,
	[Mecanismo] [nvarchar](30) NULL,
	[Resultado] [nvarchar](20) NULL,
	[Cumplimiento] [nvarchar](30) NULL,
	[Total] [nvarchar](20) NULL,
	[TipoReparacion] [int] NULL,
	[TipoConclusion] [int] NULL,
	[MontoRecuperado] [nvarchar](50) NULL,
	[MontoInmueble] [nvarchar](50) NULL,
	[Turnado] [int] NULL,
	[GeneralID] [int] NULL,
 CONSTRAINT [PK_MASC] PRIMARY KEY CLUSTERED 
(
	[MASCID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [inegi].[Victima]    Script Date: 12/04/2021 11:20:13 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [inegi].[Victima](
	[VictimaID] [int] IDENTITY(1,1) NOT NULL,
	[Sexo] [nvarchar](10) NULL,
	[Edad] [int] NULL,
	[Escolaridad] [int] NULL,
	[Ocupacion] [int] NULL,
	[Solicitante] [nvarchar](100) NULL,
	[Requerido] [nvarchar](100) NULL,
	[Tipo] [nvarchar](25) NULL,
	[GeneralID] [int] NULL,
 CONSTRAINT [PK_Victima] PRIMARY KEY CLUSTERED 
(
	[VictimaID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
USE [master]
GO
ALTER DATABASE [informe_cmasc] SET  READ_WRITE 
GO
