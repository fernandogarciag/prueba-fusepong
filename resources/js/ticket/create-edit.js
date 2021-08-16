import React from "react";
import ReactDOM from "react-dom";
import Layout from "../components/Layout";

const Root = ({ jsonData }) => {
    const data = JSON.parse(jsonData);
    const { auth, title, csrf, errors, old, project, history, ticket } = data;
    console.log(ticket.name ? true : false);
    return (
        <Layout auth={auth} csrf={csrf} title={title}>
            <a
                href={`/projects/${project.id}/histories/${history.id}/tickets${
                    ticket.name ? `/${ticket.id}` : ""
                }`}
                type="button"
                className="btn btn-primary mb-2"
            >
                Regresar
            </a>
            <form
                method="POST"
                action={`/projects/${project.id}/histories/${
                    history.id
                }/tickets${ticket.name ? `/${ticket.id}` : ""}`}
            >
                {ticket.name ? (
                    <input type="hidden" name="_method" value="PUT" />
                ) : (
                    ""
                )}
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
                            defaultValue={old.name ? old.name : ticket.name}
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
                <div className="form-group row mb-0">
                    <div className="col-md-6 offset-md-4">
                        <button type="submit" className="btn btn-primary">
                            {ticket.name ? "Editar Tiquete" : "Nuevo Tiquete"}
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
