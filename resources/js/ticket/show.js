import React from "react";
import ReactDOM from "react-dom";
import Layout from "../components/Layout";

const Root = ({ jsonData }) => {
    const data = JSON.parse(jsonData);
    const {
        auth,
        title,
        csrf,
        old,
        errors,
        project,
        history,
        ticket,
        deleteHistory,
        comments,
    } = data;
    const state = {
        1: "Activo",
        2: "En Proceso",
        3: "finalizado",
    };
    const deleteMessage = deleteHistory
        ? "\nSi lo borra, se borrara tambien la historia"
        : "";
    return (
        <Layout auth={auth} csrf={csrf} title={title}>
            <div className="mb-2">
                <a
                    href={`/projects/${project.id}/histories/${history.id}/tickets`}
                    type="button"
                    className="btn btn-primary me-2"
                >
                    Regresar
                </a>
                <a
                    href={`/projects/${project.id}/histories/${history.id}/tickets/${ticket.id}/edit`}
                    type="button"
                    className="btn btn-warning me-2"
                >
                    Editar
                </a>
                <a
                    className="btn btn-danger"
                    onClick={(e) => {
                        e.preventDefault();
                        if (
                            confirm(
                                `Esta seguro que desea borrar este tiquete.${deleteMessage}`
                            )
                        ) {
                            document.getElementById("destroy-form").submit();
                        }
                    }}
                >
                    Borrar
                </a>
                <form
                    id="destroy-form"
                    action={`/projects/${project.id}/histories/${history.id}/tickets/${ticket.id}`}
                    method="post"
                    className="d-none"
                >
                    <input type="hidden" name="_method" value="DELETE" />
                    <input type="hidden" name="_token" value={csrf} />
                </form>
            </div>
            <ul className="list-group mb-4">
                <li className="list-group-item">
                    Nombre del projecto: {project.name}
                </li>
                <li className="list-group-item">
                    Nombre de la historia: {history.name}
                </li>
                <li className="list-group-item">
                    Nombre del tiquete: {ticket.name}
                </li>
                <li className="list-group-item">
                    Estado del tiquete: {state[ticket.state]}
                </li>
            </ul>
            <form
                action={`/projects/${project.id}/histories/${history.id}/tickets/${ticket.id}/comments`}
                method="post"
            >
                <input type="hidden" name="_token" value={csrf} />
                <div className="form-group row mb-3">
                    <div className="col-md-12">
                        <textarea
                            id="content"
                            className={`form-control${
                                errors.content.length !== 0 ? " is-invalid" : ""
                            }`}
                            name="content"
                            rows="4"
                            required
                        >
                            {old.content}
                        </textarea>
                        {errors.content.length !== 0 ? (
                            <span className="invalid-feedback" role="alert">
                                <strong>{errors.content}</strong>
                            </span>
                        ) : (
                            ""
                        )}
                    </div>
                </div>
                <div className="form-group row mb-4">
                    <div className="col-md-6">
                        <button type="submit" className="btn btn-primary">
                            Crear Comentario
                        </button>
                    </div>
                </div>
            </form>
            <ul className="list-group list-group-flush">
                {comments.map((comment, index) => (
                    <li
                        key={index}
                        className="list-group-item d-flex align-items-center"
                    >
                        <a
                            className="btn btn-danger me-2"
                            onClick={(e) => {
                                e.preventDefault();
                                if (
                                    confirm(
                                        `Esta seguro que desea borrar este comentario.`
                                    )
                                ) {
                                    document
                                        .getElementById(
                                            `destroy-comment-${comment.id}`
                                        )
                                        .submit();
                                }
                            }}
                        >
                            Borrar
                        </a>
                        <form
                            id={`destroy-comment-${comment.id}`}
                            action={`/projects/${project.id}/histories/${history.id}/tickets/${ticket.id}/comments/${comment.id}`}
                            method="post"
                            className="d-none"
                        >
                            <input
                                type="hidden"
                                name="_method"
                                value="DELETE"
                            />
                            <input type="hidden" name="_token" value={csrf} />
                        </form>
                        <span>
                            {comment.name} {comment.updated_at}:{" "}
                            {comment.content}
                        </span>
                    </li>
                ))}
            </ul>
        </Layout>
    );
};

if (document.getElementById("root")) {
    const data = document.getElementById("root").getAttribute("data");
    ReactDOM.render(<Root jsonData={data} />, document.getElementById("root"));
}
