// SPDX-License-Identifier: MIT

pragma solidity ^0.8.0;


contract AcademicRecords {
    // Estructura para almacenar los registros académicos de un estudiante
    struct StudentRecord {
        string studentName;
        uint256[] grades;
        address school;
    }
    
    // Mapeo de direcciones de estudiantes a sus registros académicos
    mapping(address => StudentRecord) public studentRecords;
    
    // Función para añadir un nuevo registro académico
    function addAcademicRecord(string memory _studentName, uint256[] memory _grades) public {
        studentRecords[msg.sender] = StudentRecord(_studentName, _grades, msg.sender);
    }
    
    // Función para obtener los registros académicos de un estudiante
    function getAcademicRecord(address _studentAddress) public view returns(string memory, uint256[] memory) {
        return (studentRecords[_studentAddress].studentName, studentRecords[_studentAddress].grades);
    }
}
