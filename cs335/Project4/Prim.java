import java.io.*;
import java.util.*;

public class Prim {

	public static void main(String[] args) {
		//Create file reader
		BufferedReader reader = null;
		try {
			reader = new BufferedReader(new FileReader("disneyland.txt"));
		} catch (FileNotFoundException e) {
			System.out.println("Error: " + e);
		}
		String strRead = "";
		int size = 84;
		MyGraph disneyland = new MyGraph(size+1);
		List<Node> vertices = new ArrayList<Node>();
		//Read file
		try {
			int count = 0;
			reader.readLine();
			while ((strRead = reader.readLine()) != null && count < size) {
				String splitArray[] = strRead.split(" ");
				int id = Integer.parseInt(splitArray[0]);
				int x = Integer.parseInt(splitArray[1]);
				int y = Integer.parseInt(splitArray[2]);
				String name = splitArray[3];
				Node vert = new Node(id,x,y,name);
				//System.out.format("ID: %d, (%d,%d), Name: %s\n",id,x,y,name);
				vertices.add(vert);
				count++;
			}
		} catch (IOException e) {
			System.out.println("Error: " + e);
		}
		//Create the complete graph representation as an adjacency matrix
		for (int i=0; i<size; i++) {
			for (int j=0; j<size; j++) {
				//Add edge to graph
				if (i!=j)
					disneyland.addEdge(vertices.get(i),vertices.get(j));
					//System.out.print(disneyland.hasEdge(vertices.get(i),vertices.get(j))+" ");
			}
			//System.out.println();
		}
		//Graph is created. Next is Prims Algorithm
		System.out.println("Loaded graph.");
		long start = System.nanoTime();
		Set<Edge> edges = new LinkedHashSet<Edge>();
		PriorityQueue<Edge> availableEdges = new PriorityQueue<Edge>(84, new Comparator<Edge>() {
			public int compare(Edge e0, Edge e1) {
				double w0 = e0.getWeight();
				double w1 = e1.getWeight();
				if (w1 > w0) return -1;
				else if (w1 < w0) return 1;
				else return 0;
			}
		});

		List<Node> visited = new ArrayList<Node>();
		Node someV = vertices.get(1);
		visited.add(someV);
		for (Node v : vertices) {
			if (disneyland.hasEdge(someV,v))
				availableEdges.add(new Edge(someV,v));
		}
		double weight = 0.0;
		Edge e = new Edge();
		Node v0 = new Node();
		Node v1 = new Node();

		for (int i=0; i<size-1; i++) {
			while (!availableEdges.isEmpty()) {
				e = availableEdges.remove();
				v0 = e.getSource();
				v1 = e.getDestination();
				if (visited.contains(v0) && !visited.contains(v1))
					break;
			}
			Node w = e.getDestination();
			edges.add(e);
			weight += e.getWeight();
			visited.add(w);
			for (Node v : vertices){
				if (v!=w && disneyland.hasEdge(w,v))
					availableEdges.add(new Edge(w,v));
			}
		}
		long elapsed = System.nanoTime() - start;
		System.out.format("Prim's Algorithm took %.2f seconds\n",(elapsed/1000000000.0));
		System.out.println("MST Edges:");
		for (Edge ed : edges) {
			v0 = ed.getSource();
			v1 = ed.getDestination();
			System.out.format("(%d)[%s] <-> (%d)[%s] Weight: %.02f\n",v0.getId(),v0.getName(),
							v1.getId(),v1.getName(),ed.getWeight());
		}
		System.out.format("Total Weight: %.02f",weight);

	}
}
