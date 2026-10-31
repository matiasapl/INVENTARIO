import '../../css/landing.css';

import { dashboard, login, register } from '@/routes';
import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';
import {
    ArrowLeft,
    ArrowRight,
    ArrowUpRight,
    Boxes,
    ClipboardList,
    Layers3,
    MapPinned,
    Package,
    Warehouse,
} from 'lucide-react';
import {
    useEffect,
    useRef,
    useState,
    type KeyboardEvent,
    type TouchEvent,
} from 'react';

const views = [
    {
        title: 'Dashboard',
        description:
            'Una vista general para empezar a explorar tus productos y su información.',
        image: '/images/landing/dashboard.jpg',
        alt: 'Dashboard de INVENTARIO con una tabla de productos de demostración.',
    },
    {
        title: 'Productos',
        description:
            'Consulta y organiza el catálogo que luego relacionas con tus lotes.',
        image: '/images/landing/productos.jpg',
        alt: 'Listado de productos ficticios en la plataforma INVENTARIO.',
    },
    {
        title: 'Almacenes',
        description:
            'Mantén las ubicaciones de almacenamiento vinculadas a tu cuenta.',
        image: '/images/landing/almacenes.jpg',
        alt: 'Listado de almacenes de demostración con nombres y ubicaciones ficticios.',
    },
    {
        title: 'Lotes',
        description:
            'Registra cantidades por producto y almacén desde un mismo módulo.',
        image: '/images/landing/lotes.jpg',
        alt: 'Listado de lotes ficticios con producto, cantidad y almacén asociado.',
    },
    {
        title: 'Actividad',
        description:
            'Revisa las operaciones de inventario registradas en tu cuenta.',
        image: '/images/landing/actividad.jpg',
        alt: 'Registro de actividad con operaciones sintéticas de inventario.',
    },
];

const capabilities = [
    {
        title: 'Productos',
        description:
            'Un catálogo para consultar nombres, descripciones y datos unitarios.',
        icon: Package,
    },
    {
        title: 'Almacenes',
        description:
            'Ubicaciones organizadas para saber dónde se encuentra cada lote.',
        icon: Warehouse,
    },
    {
        title: 'Lotes y cantidades',
        description:
            'Relaciona productos con almacenes y registra sus cantidades.',
        icon: Layers3,
    },
    {
        title: 'Actividad',
        description:
            'Consulta los cambios de inventario registrados en tu espacio.',
        icon: ClipboardList,
    },
];

const steps = [
    { number: '01', label: 'Organiza tus productos' },
    { number: '02', label: 'Define tus almacenes' },
    { number: '03', label: 'Registra lotes y cantidades' },
    { number: '04', label: 'Consulta la actividad' },
];

export default function Welcome({
    canRegister = true,
}: {
    canRegister?: boolean;
}) {
    const { auth } = usePage<SharedData>().props;
    const [activeView, setActiveView] = useState(0);
    const touchStart = useRef<number | null>(null);

    useEffect(() => {
        views.forEach(({ image }) => {
            const preload = new Image();
            preload.src = image;
        });
    }, []);

    const isAuthenticated = Boolean(auth.user);
    const demoHref = isAuthenticated
        ? dashboard()
        : canRegister
          ? register()
          : login();
    const demoLabel = isAuthenticated
        ? 'Ir a mi inventario'
        : canRegister
          ? 'Probar demo'
          : 'Iniciar sesión';
    const activeSlide = views[activeView];

    const showPrevious = () => {
        setActiveView((current) => (current - 1 + views.length) % views.length);
    };

    const showNext = () => {
        setActiveView((current) => (current + 1) % views.length);
    };

    const handleCarouselKeyDown = (event: KeyboardEvent<HTMLElement>) => {
        if (event.key === 'ArrowLeft') {
            event.preventDefault();
            showPrevious();
        }

        if (event.key === 'ArrowRight') {
            event.preventDefault();
            showNext();
        }
    };

    const handleTouchStart = (event: TouchEvent<HTMLElement>) => {
        touchStart.current = event.changedTouches[0]?.clientX ?? null;
    };

    const handleTouchEnd = (event: TouchEvent<HTMLElement>) => {
        const start = touchStart.current;
        const end = event.changedTouches[0]?.clientX;

        if (start === null || end === undefined) return;

        const distance = end - start;
        if (Math.abs(distance) > 48) {
            distance > 0 ? showPrevious() : showNext();
        }

        touchStart.current = null;
    };

    return (
        <>
            <Head title="Inventario | gestión de inventarios">
                <meta
                    name="description"
                    content="Explora INVENTARIO, una demo para gestionar productos, almacenes, lotes y actividad desde una cuenta individual."
                />
                <meta name="theme-color" content="#173b4a" />
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link
                    href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|barlow-semi-condensed:500,600,700"
                    rel="stylesheet"
                />
            </Head>

            <div className="landing-page">
                <a className="landing-skip-link" href="#contenido">
                    Saltar al contenido
                </a>

                <header className="landing-header">
                    <div className="landing-shell landing-header-inner">
                        <a
                            className="landing-brand"
                            href="/"
                            aria-label="INVENTARIO, inicio"
                        >
                            <span
                                className="landing-brand-mark"
                                aria-hidden="true"
                            >
                                <Boxes size={21} strokeWidth={1.8} />
                            </span>
                            <span>INVENTARIO</span>
                        </a>

                        <nav
                            className="landing-nav"
                            aria-label="Navegación principal"
                        >
                            <a href="#funciones">Funciones</a>
                            <a href="#recorrido">Recorrido</a>
                            <a href="#proyecto">Proyecto</a>
                        </nav>

                        <div className="landing-header-actions">
                            {!isAuthenticated && (
                                <Link
                                    className="landing-login-link"
                                    href={login()}
                                >
                                    Iniciar sesión
                                </Link>
                            )}
                            <Link
                                className="landing-button landing-button-small"
                                href={demoHref}
                            >
                                {demoLabel}
                                <ArrowUpRight size={16} aria-hidden="true" />
                            </Link>
                        </div>
                    </div>
                </header>

                <main id="contenido">
                    <section
                        className="landing-hero landing-shell"
                        aria-labelledby="hero-title"
                    >
                        <div className="landing-hero-copy">
                            <p className="landing-status">
                                <span aria-hidden="true" />
                                Demo interactiva · cuentas individuales
                            </p>
                            <h1 id="hero-title">
                                Todo tu inventario, bajo control.
                            </h1>
                            <p className="landing-hero-description">
                                Organiza productos, almacenes y lotes. Explora
                                cómo se conectan y revisa la actividad de tu
                                inventario.
                            </p>
                            <div className="landing-hero-actions">
                                <Link
                                    className="landing-button"
                                    href={demoHref}
                                >
                                    {demoLabel}
                                    <ArrowUpRight
                                        size={17}
                                        aria-hidden="true"
                                    />
                                </Link>
                                <a className="landing-text-link" href="#vistas">
                                    Explorar la plataforma
                                    <ArrowRight size={16} aria-hidden="true" />
                                </a>
                            </div>
                            <p className="landing-account-note">
                                Cada cuenta mantiene sus propios datos.
                            </p>
                        </div>

                        <section
                            id="vistas"
                            className="landing-showcase"
                            aria-labelledby="showcase-title"
                            aria-roledescription="carrusel"
                            aria-label="Vistas de la plataforma"
                            onKeyDown={handleCarouselKeyDown}
                            onTouchStart={handleTouchStart}
                            onTouchEnd={handleTouchEnd}
                        >
                            <div className="landing-showcase-topline">
                                <h2 id="showcase-title">
                                    Explora la plataforma
                                </h2>
                                <span className="landing-location-tag">
                                    <MapPinned size={14} aria-hidden="true" />
                                    Vista{' '}
                                    {String(activeView + 1).padStart(
                                        2,
                                        '0',
                                    )} / {String(views.length).padStart(2, '0')}
                                </span>
                            </div>

                            <figure className="landing-screen-frame">
                                <div
                                    className="landing-screen-chrome"
                                    aria-hidden="true"
                                >
                                    <span />
                                    <span />
                                    <span />
                                    <span className="landing-screen-address" />
                                </div>
                                <img
                                    key={activeSlide.image}
                                    className="landing-screen-image"
                                    src={activeSlide.image}
                                    alt={activeSlide.alt}
                                    width="1440"
                                    height="900"
                                    fetchPriority={
                                        activeView === 0 ? 'high' : 'auto'
                                    }
                                />
                            </figure>

                            <div className="landing-showcase-caption">
                                <div aria-live="polite" aria-atomic="true">
                                    <p className="landing-slide-title">
                                        {activeSlide.title}
                                    </p>
                                    <p className="landing-slide-description">
                                        {activeSlide.description}
                                    </p>
                                </div>
                                <div className="landing-carousel-controls">
                                    <button
                                        type="button"
                                        className="landing-carousel-arrow"
                                        aria-label="Vista anterior"
                                        onClick={showPrevious}
                                    >
                                        <ArrowLeft
                                            size={18}
                                            aria-hidden="true"
                                        />
                                    </button>
                                    <div
                                        className="landing-carousel-dots"
                                        aria-label="Elegir vista"
                                    >
                                        {views.map((view, index) => (
                                            <button
                                                key={view.title}
                                                type="button"
                                                className={[
                                                    'landing-carousel-dot',
                                                    index === activeView &&
                                                        'is-active',
                                                ]
                                                    .filter(Boolean)
                                                    .join(' ')}
                                                aria-label={`Mostrar vista: ${view.title}`}
                                                aria-pressed={
                                                    index === activeView
                                                }
                                                onClick={() =>
                                                    setActiveView(index)
                                                }
                                            />
                                        ))}
                                    </div>
                                    <button
                                        type="button"
                                        className="landing-carousel-arrow landing-carousel-arrow-next"
                                        aria-label="Vista siguiente"
                                        onClick={showNext}
                                    >
                                        <ArrowRight
                                            size={18}
                                            aria-hidden="true"
                                        />
                                    </button>
                                </div>
                            </div>
                        </section>
                    </section>

                    <section
                        id="funciones"
                        className="landing-capabilities"
                        aria-labelledby="capabilities-title"
                    >
                        <div className="landing-shell">
                            <div className="landing-section-heading">
                                <p className="landing-section-index">
                                    01 / Lo esencial
                                </p>
                                <h2 id="capabilities-title">
                                    Las piezas de tu inventario, conectadas.
                                </h2>
                                <p>
                                    Cuatro áreas para explorar el recorrido de
                                    un producto, desde su registro hasta su
                                    ubicación.
                                </p>
                            </div>

                            <div className="landing-capability-list">
                                {capabilities.map(
                                    ({ title, description, icon: Icon }) => (
                                        <article
                                            className="landing-capability"
                                            key={title}
                                        >
                                            <span
                                                className="landing-capability-icon"
                                                aria-hidden="true"
                                            >
                                                <Icon
                                                    size={23}
                                                    strokeWidth={1.7}
                                                />
                                            </span>
                                            <h3>{title}</h3>
                                            <p>{description}</p>
                                            <span
                                                className="landing-capability-rule"
                                                aria-hidden="true"
                                            />
                                        </article>
                                    ),
                                )}
                            </div>
                        </div>
                    </section>

                    <section
                        id="recorrido"
                        className="landing-flow landing-shell"
                        aria-labelledby="flow-title"
                    >
                        <div className="landing-flow-intro">
                            <p className="landing-section-index">
                                02 / Un recorrido simple
                            </p>
                            <h2 id="flow-title">De producto a ubicación.</h2>
                            <p>
                                Explora cómo una pieza del catálogo se relaciona
                                con el espacio donde se almacena.
                            </p>
                        </div>
                        <ol className="landing-steps">
                            {steps.map((step) => (
                                <li className="landing-step" key={step.number}>
                                    <span>{step.number}</span>
                                    <p>{step.label}</p>
                                </li>
                            ))}
                        </ol>
                    </section>

                    <section
                        className="landing-demo-note"
                        aria-labelledby="demo-note-title"
                    >
                        <div className="landing-shell landing-demo-note-inner">
                            <div className="landing-demo-note-copy">
                                <p className="landing-section-index">
                                    03 / Antes de entrar
                                </p>
                                <h2 id="demo-note-title">
                                    Una demo para explorar, no para operar.
                                </h2>
                                <p>
                                    Crea una cuenta individual y prueba la
                                    plataforma con tus propios datos. Usa
                                    información ficticia: esta versión es un
                                    proyecto de portafolio, no un servicio para
                                    inventario real.
                                </p>
                            </div>
                            <Link
                                className="landing-button landing-button-light"
                                href={demoHref}
                            >
                                {demoLabel}
                                <ArrowUpRight size={17} aria-hidden="true" />
                            </Link>
                        </div>
                    </section>

                    <section
                        id="proyecto"
                        className="landing-project landing-shell"
                        aria-labelledby="project-title"
                    >
                        <div>
                            <p className="landing-section-index">
                                04 / El proyecto
                            </p>
                            <h2 id="project-title">
                                Hecho para aprender construyendo.
                            </h2>
                            <p>
                                INVENTARIO es un proyecto personal creado con
                                Laravel, React e Inertia. Conoce el código o
                                visita el portafolio del autor.
                            </p>
                        </div>
                        <div className="landing-project-links">
                            <a
                                href="https://github.com/matiasapl/INVENTARIO"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                Ver el repositorio
                                <ArrowUpRight size={16} aria-hidden="true" />
                            </a>
                            <a
                                href="https://mapl.dev/"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                Visitar mapl.dev
                                <ArrowUpRight size={16} aria-hidden="true" />
                            </a>
                        </div>
                    </section>
                </main>

                <footer className="landing-footer">
                    <div className="landing-shell landing-footer-inner">
                        <a
                            className="landing-brand landing-brand-footer"
                            href="/"
                        >
                            <span
                                className="landing-brand-mark"
                                aria-hidden="true"
                            >
                                <Boxes size={18} strokeWidth={1.8} />
                            </span>
                            <span>INVENTARIO</span>
                        </a>
                        <p>
                            Demo de portafolio · Datos ficticios · No usar con
                            inventario real
                        </p>
                        <Link className="landing-footer-cta" href={demoHref}>
                            {demoLabel}
                            <ArrowUpRight size={14} aria-hidden="true" />
                        </Link>
                        <div className="landing-footer-project-links">
                            <a
                                href="https://github.com/matiasapl/INVENTARIO"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                Código
                            </a>
                            <a
                                href="https://mapl.dev/"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                Portafolio
                            </a>
                        </div>
                        <a href="#contenido" className="landing-back-top">
                            Volver arriba{' '}
                            <ArrowUpRight size={14} aria-hidden="true" />
                        </a>
                    </div>
                </footer>
            </div>
        </>
    );
}
