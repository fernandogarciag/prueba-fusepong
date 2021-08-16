import React from "react";
import ReactDOM from "react-dom";
import Layout from "../components/Layout";

const Root = ({ jsonData }) => {
    const data = JSON.parse(jsonData);
    const { auth, title, csrf, project, histories } = data;
    console.log(typeof histories);
    return (
        <Layout auth={auth} csrf={csrf} title={title}>
            <div className="mb-2">
                <a
                    href={`/projects`}
                    type="button"
                    className="btn btn-primary me-2"
                >
                    Regresar
                </a>
                <a
                    className="btn btn-primary"
                    href={`/projects/${project.id}/histories/create`}
                >
                    Nueva Historia
                </a>
            </div>
            <table className="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre:</th>
                        <th scope="col">Creado por:</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    {histories.map((history, index) => (
                        <tr key={index}>
                            <th scope="row">{index + 1}</th>
                            <td>{history.historyName}</td>
                            <td>{history.userName}</td>
                            <td>
                                <a
                                    className="btn btn-primary me-1"
                                    href={`/projects/${project.id}/histories/${history.id}/tickets`}
                                >
                                    Tiquetes
                                </a>
                                <a
                                    className="btn btn-info"
                                    href={`/projects/${project.id}/histories/${history.id}`}
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
