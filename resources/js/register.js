import React from "react";
import ReactDOM from "react-dom";
import Layout from "./components/Layout";

const Root = ({ jsonData }) => {
    const data = JSON.parse(jsonData);
    const { auth, title, csrf, companies, old, errors } = data;
    return (
        <Layout auth={auth} csrf={csrf} title={title}>
            <form method="POST" action="/register">
                <input type="hidden" name="_token" value={csrf} />
                <div className="form-group row mb-3">
                    <label
                        htmlFor="name"
                        className="col-md-4 col-form-label text-md-right"
                    >
                        Nombre
                    </label>
                    <div className="col-md-6">
                        <input
                            id="name"
                            type="text"
                            className={`form-control${
                                errors.name.length !== 0 ? " is-invalid" : ""
                            }`}
                            defaultValue={old.name}
                            name="name"
                            autoComplete="name"
                            required
                            autoFocus
                        />
                        {errors.name.length !== 0 ? (
                            <span className="invalid-feedback" role="alert">
                                <strong>{errors.name}</strong>
                            </span>
                        ) : (
                            ""
                        )}
                    </div>
                </div>
                <div className="form-group row mb-3">
                    <label
                        htmlFor="email"
                        className="col-md-4 col-form-label text-md-right"
                    >
                        E-Mail
                    </label>
                    <div className="col-md-6">
                        <input
                            id="email"
                            type="email"
                            className={`form-control${
                                errors.email.length !== 0 ? " is-invalid" : ""
                            }`}
                            defaultValue={old.email}
                            name="email"
                            autoComplete="email"
                            required
                        />
                        {errors.email.length !== 0 ? (
                            <span className="invalid-feedback" role="alert">
                                <strong>{errors.email}</strong>
                            </span>
                        ) : (
                            ""
                        )}
                    </div>
                </div>
                <div className="form-group row mb-3">
                    <label
                        htmlFor="company"
                        className="col-md-4 col-form-label text-md-right"
                    >
                        Compañia
                    </label>
                    <div className="col-md-6">
                        <select
                            id="company"
                            type="company"
                            className={`form-control${
                                errors.company.length !== 0 ? " is-invalid" : ""
                            }`}
                            name="company"
                            defaultValue={old.company}
                            required
                        >
                            <option>Escoge tu compañia</option>

                            {companies.map((company, index) => (
                                <option key={index} value={company.id}>
                                    {company.name}
                                </option>
                            ))}
                        </select>
                        {errors.company.length !== 0 ? (
                            <span className="invalid-feedback" role="alert">
                                <strong>{errors.company}</strong>
                            </span>
                        ) : (
                            ""
                        )}
                    </div>
                </div>
                <div className="form-group row mb-3">
                    <label
                        htmlFor="password"
                        className="col-md-4 col-form-label text-md-right"
                    >
                        Contraseña
                    </label>
                    <div className="col-md-6">
                        <input
                            id="password"
                            type="password"
                            className={`form-control${
                                errors.password.length !== 0
                                    ? " is-invalid"
                                    : ""
                            }`}
                            name="password"
                            required
                            autoComplete="new-password"
                        />
                        {errors.password.length !== 0 ? (
                            <span className="invalid-feedback" role="alert">
                                <strong>{errors.password}</strong>
                            </span>
                        ) : (
                            ""
                        )}
                    </div>
                </div>
                <div className="form-group row mb-3">
                    <label
                        htmlFor="password-confirm"
                        className="col-md-4 col-form-label text-md-right"
                    >
                        Confirmar Contraseña
                    </label>
                    <div className="col-md-6">
                        <input
                            id="password-confirm"
                            type="password"
                            className="form-control"
                            name="password_confirmation"
                            required
                            autoComplete="new-password"
                        />
                    </div>
                </div>
                <div className="form-group row mb-0">
                    <div className="col-md-6 offset-md-4">
                        <button type="submit" className="btn btn-primary">
                            Registrarse
                        </button>
                    </div>
                </div>
            </form>
        </Layout>
    );
};

if (document.getElementById("root")) {
    const data = document.getElementById("root").getAttribute("data");
    ReactDOM.render(<Root jsonData={data} />, document.getElementById("root"));
}
