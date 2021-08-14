import React, { useState } from "react";
import ReactDOM from "react-dom";
import Layout from "./components/Layout";

function Root({ jsonData }) {
    const data = JSON.parse(jsonData);
    const { auth, title, csrf, old, errors } = data;
    const [remember, setRemember] = useState(old.remember ? true : false);
    console.log(data);
    return (
        <Layout auth={auth} csrf={csrf} title={title}>
            <form method="POST" action="login">
                <input type="hidden" name="_token" value={csrf} />

                <div className="form-group row mb-3">
                    <label
                        htmlFor="email"
                        className="col-md-4 col-form-label text-md-right"
                    >
                        Correo
                    </label>

                    <div className="col-md-6">
                        <input
                            id="email"
                            type="email"
                            className={`form-control${
                                errors.email.length !== 0 ? " is-invalid" : ""
                            }`}
                            name="email"
                            defaultValue={old.email}
                            required
                            autoComplete="email"
                            autoFocus
                        />
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
                                errors.email.length !== 0 ? " is-invalid" : ""
                            }`}
                            name="password"
                            required
                            autoComplete="current-password"
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
                    <div className="col-md-6 offset-md-4">
                        <div className="form-check">
                            <input
                                className="form-check-input"
                                type="checkbox"
                                name="remember"
                                id="remember"
                                checked={remember}
                                onChange={() => {
                                    setRemember(!remember);
                                }}
                            />

                            <label
                                className="form-check-label"
                                htmlFor="remember"
                            >
                                Recuerdame
                            </label>
                        </div>
                    </div>
                </div>
                <div className="form-group row mb-0">
                    <div className="col-md-8 offset-md-4">
                        <button type="submit" className="btn btn-primary">
                            Log In
                        </button>
                    </div>
                </div>
            </form>
        </Layout>
    );
}

if (document.getElementById("root")) {
    const data = document.getElementById("root").getAttribute("data");
    ReactDOM.render(<Root jsonData={data} />, document.getElementById("root"));
}
