import React from "react";
import ReactDOM from "react-dom";
import Layout from "../components/Layout";

const Root = ({ jsonData }) => {
    const data = JSON.parse(jsonData);
    const { auth, title, csrf, projects } = data;
    return (
        <Layout auth={auth} csrf={csrf} title={title}>
            <table className="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre:</th>
                        <th scope="col">
                            <a
                                className="btn btn-primary"
                                href="/projects/create"
                            >
                                Nuevo Projecto
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {projects.map((project, index) => (
                        <tr key={index}>
                            <th scope="row">{index + 1}</th>
                            <td>{project.name}</td>
                            <td>
                                <a
                                    className="btn btn-primary me-1"
                                    href={`/projects/${project.id}/histories`}
                                >
                                    Historias
                                </a>
                                <a
                                    className="btn btn-info"
                                    href={`/projects/${project.id}`}
                                >
                                    Info
                                </a>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </Layout>
    );
};

if (document.getElementById("root")) {
    const data = document.getElementById("root").getAttribute("data");
    ReactDOM.render(<Root jsonData={data} />, document.getElementById("root"));
}
